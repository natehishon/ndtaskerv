<template>

    <div class="">



        <div class="folder-table mt-4">


            <b-row>
                <b-col cols="10" offset-sm="1">

                    <div class="breadcrumb-container">
                        <ul class="breadcrumb-ul">
                            <li v-for="(crumb, index) in breadCrumbs" v-if="crumb" @click="crumbClick(index)"><span>{{crumb}}</span>
                            </li>
                        </ul>
                    </div>

                    <b-table
                            :items="folders"
                            :fields="fields"
                            ref="selectableTable"
                            @row-clicked="choose"
                            responsive="sm"
                            :tbody-tr-class="rowClass">

                        <template v-slot:cell(image)="data">
                            <div style="height: 100px;">
                                <img v-bind:src="data.item.imageUrl" style="height: 100px;">
                            </div>
                        </template>

                    </b-table>

                    <b-modal footer-bg-variant="dark"
                             footer-text-variant="light"
                             id="modalID" size="xl"
                             :title="task.title"

                    >
                        <Task v-on:task-slide="changeSlide" :task="task"></Task>
                        <template v-slot:modal-footer>
                            <BottomNotch v-if="task" :current-slide="task.sub_task[currentSlide]"></BottomNotch>
                        </template>
                    </b-modal>
                </b-col>

            </b-row>
        </div>
    </div>

</template>

<script>

    import axios from 'axios';
    import Task from '../task/Task'
    import BottomNotch from '../jots/BottomNotch'

    export default {
        components: {
            Task,
            BottomNotch
        },

        props: ['name'],

        data() {
            return {
                folders: null,
                fields: [
                    {key: 'image', sortable: false, tdClass: 'imageColumn'},
                    {key: 'title', sortable: true,},
                    {key: 'type', sortable: true, },

                ],
                task: {id: "0", title: "", sub_task: []},
                currentSlide: 0,
                breadCrumbs: ['home']
            }
        },
        methods: {
            crumbClick(crumb) {
                console.log(crumb);
                console.log(this.breadCrumbs);
                let url = "";
                for (let i = 1; i <= crumb; i++) {
                    url += "/" + this.breadCrumbs[i];
                }


                // window.location.href = window.location.origin + url;
                if (url) {
                    this.$router.replace({path: url})
                } else {
                    this.$router.replace({name: 'home'})
                }

            },
            choose(row) {

                if (row.type === 'Task') {
                    this.task = row;
                    this.$bvModal.show("modalID");
                }

                if (row.type === 'Folder') {
                    this.$router.push(this.$router.currentRoute.path + '/' + row.slug)
                }
            },

            changeSlide(event) {
                this.currentSlide = event
            },
            rowClass(item, type) {
                if (!item || type !== 'row') return
                // if (item.type === 'Task') return 'table-success'
            },
        },

        created() {
            // this.loading = true;
            let path = "";
            if (this.$route.params) {
                if (this.$route.params.pathMatch) {
                    path = this.$route.params.pathMatch;
                    // path = slash.replace(/[^0-9a-z]/gi, '')
                }
            }

            let trim = this.$route.path;
            let trimmed = trim.replace(/^\/|\/$/g, '');
            console.log("trim");
            console.log(trimmed);
            let split = trimmed.split("/");

            this.breadCrumbs = this.breadCrumbs.concat(split)

            let last = this.breadCrumbs.slice(-1)[0];

            if (last === 'folders') {
                axios.get('folders').then(response => {
                    console.log("1");

                    this.folders = response.data.table;


                }).catch(err => {
                    console.log(err);
                });
            } else {
                axios.get('folders/' + last).then(response => {
                    console.log("2");

                    this.folders = response.data.table;


                }).catch(err => {
                    console.log(err);
                });
            }
        }

    }

</script>

<style lang="scss">

    .imageColumn {
        width: 130px;
    }

    .folder-table {
        tr {
            cursor: pointer;
            outline: none;
        }

        td {
            cursor: pointer !important;
            outline: none;
        }
    }

    .breadcrumb-ul {
        display: flex;
        flex-wrap: wrap;
        -webkit-box-pack: start;
        justify-content: flex-start;
        /*margin: 30px 0;*/
        padding: 0;

        li {
            align-items: center;
            display: flex;

            span {
                padding: 0 .75em;
                font-weight: 900;
                cursor: pointer;
            }
        }

        li:first-child {
            padding-left: 0
        }

        li + li:before {
            color: #b5b5b5;
            content: "\0002f";
        }
    }

</style>