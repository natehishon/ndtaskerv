<template>

    <div class="">


        <div class="folder-table mt-4">
            <b-row>
                <b-col cols="10" offset-sm="1">

                    <!--                    <b-alert show dismissible>-->
                    <!--                        welcome to wayfinder-->
                    <!--                    </b-alert>-->

                    <div class="breadcrumb-container">
                        <ul class="breadcrumb-ul">
                            <li v-for="(crumb, index) in breadCrumbs" v-if="crumb" @click="crumbClick(index)"><span>{{crumb}}</span>
                            </li>
                        </ul>

                        <div class="search-container">
                            <b-button size="sm" @click="openSearchModal()" variant="light" class="search-button">
                                <i class="fas fa-search"></i> search
                            </b-button>
                        </div>

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

                        <template v-slot:cell(type)="data">
                            <div>
                                <b-badge variant="info" v-if="data.item.type === 'task'"><i
                                    class="fas fa-list fa-fw"></i>task
                                </b-badge>
                                <b-badge variant="primary" v-if="data.item.type === 'folder'"><i
                                    class="fas fa-folder fa-fw"></i>folder
                                </b-badge>
                                <!--                                <i v-bind:class="{ 'fas fa-list-alt': data.item.type === 'task', 'fas fa-folder': data.item.type === 'folder' }"></i>-->
                                <!--                                <span>{{data.item.type}}-->
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


        <b-modal
            id="searchModal" size="xl"
            title="search"
        >
            <div class="container-fluid">
                <b-row>
                    <b-col cols="10" offset-sm="1" class="search-form-container">
                        <b-input
                            v-model="searchQuery"
                            class="mb-2 mr-sm-2 mb-sm-0"
                            placeholder="search for something"
                        ></b-input>
                        <div class="search-button-container">
                            <b-button size="md" @click="search()" variant="primary">
                                <i class="fas fa-search"></i> search
                            </b-button>
                        </div>

                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="10" offset-sm="1">

                        <div class="search-result-container">
                            <div class="tasks-container" v-if="searchResponse.tasks.length > 0">
                                tasks:
                                <ul class="search-list">
                                    <li v-for="(result, index) in searchResponse.tasks"
                                        @click="searchTaskSelect(result)"><span>{{result.title}}</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="tasks-container" v-if="searchResponse.folders.length > 0">
                                folders:
                            </div>
                        </div>

                    </b-col>
                </b-row>

                <!--                <form enctype="multipart/form-data">-->
                <!--                    <div class="row">-->
                <!--                        <div class="col-xs-12">-->
                <!--                            <div class="form-group">-->
                <!--                                <label for="title">Title</label>-->
                <!--                                <input type="text" class="form-control"-->
                <!--                                       v-model="newFolder.title">-->
                <!--                            </div>-->

                <!--                            <div class="form-group">-->
                <!--                                <label>folder image</label>-->
                <!--                                <input type="file" ref="file" @change="selectFolderFiles"/>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </form>-->
            </div>

            <template v-slot:modal-footer>
                <b-button size="md" @click="close" variant="secondary">
                    <i class="fas fa-times "></i> cancel
                </b-button>
            </template>
        </b-modal>

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
                searchQuery: "",
                searchResponse: {
                    tasks: [],
                    folders: []
                },
                fields: [
                    {key: 'image', sortable: false, tdClass: 'imageColumn'},
                    {key: 'title', sortable: true,},
                    {key: 'type', sortable: true,},

                ],
                task: {id: "0", title: "", sub_task: []},
                currentSlide: 0,
                breadCrumbs: ['home']
            }
        },
        methods: {

            openSearchModal() {
                this.$bvModal.show("searchModal");
            },

            crumbClick(crumb) {
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

                if (row.type === 'task') {
                    this.task = row;
                    this.$bvModal.show("modalID");
                }

                if (row.type === 'folder') {
                    this.$router.push(this.$router.currentRoute.path + '/' + row.slug)
                }
            },

            changeSlide(event) {
                this.currentSlide = event
            },
            rowClass(item, type) {
                if (!item || type !== 'row') return
            },

            searchTaskSelect(result) {
                // console.log(this.$route.name);
                // this.$router.push({name: 'home', path: `${result.fullSlug}`})

                if (this.$router.currentRoute.path === "/"){
                    this.$router.replace(`${result.fullSlug}`)
                } else {
                    this.$router.push({name: 'home'},
                        () => this.$router.replace(`${result.fullSlug}`))
                }
            },

            traverse(object, slug) {

                slug = object.slug + '/' + slug;

                if(object.all_parents){
                    return this.traverse(object.all_parents, slug)
                } else {
                    return slug;
                }
            },

            search() {

                let formData = {
                    search: this.searchQuery
                }

                axios.post('/search/user-search', formData).then(response => {

                    //add to
                    console.log(response.data);

                    this.searchResponse = response.data;

                    if(this.searchResponse.tasks){
                        console.log(this.searchResponse.tasks);
                        for (let child of this.searchResponse.tasks) {

                            child.fullSlug = this.traverse(child, "");

                        }

                        console.log("results");
                        console.log(this.searchResponse.tasks);
                    }

                }).catch(err => {
                    console.log(err);
                });

                console.log(this.searchQuery);
            },
            close() {
                this.$bvModal.hide("searchModal");
            }
        },

        created() {
            let path = "";
            if (this.$route.params) {
                if (this.$route.params.pathMatch) {
                    path = this.$route.params.pathMatch;
                }
            }

            let trim = this.$route.path;
            let trimmed = trim.replace(/^\/|\/$/g, '');
            let split = trimmed.split("/");
            // console.log(split);
            // let decode = split[0].replace("+", " ")

            this.breadCrumbs = this.breadCrumbs.concat(split)

            let last = this.breadCrumbs.slice(-1)[0];

            if (last === 'folders') {
                axios.get('folders').then(response => {
                    this.folders = response.data.table;
                }).catch(err => {
                    console.log(err);
                });
            } else {
                axios.get('folders/' + last).then(response => {
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

        font-size: 22px;

        tr {
            cursor: pointer;
            outline: none;
        }

        td {
            cursor: pointer !important;
            outline: none;
        }

        table {
            thead {
                th {
                    border-top: 0;
                }
            }
        }
    }

    .breadcrumb-container {

        display: flex;
        flex-direction: row;
        justify-content: space-between;

        margin-bottom: 50px;


        .search-container {
            display: flex;
            align-items: center;

            .search-button {
                font-size: 22px;

            }
        }


        .breadcrumb-ul {
            display: flex;
            flex-wrap: wrap;
            -webkit-box-pack: start;
            justify-content: flex-start;
            /*margin: 30px 0;*/
            padding: 0;
            font-size: 22px;
            font-weight: 500;

            li {
                align-items: center;
                display: flex;

                span {
                    padding: 0.75em;
                    font-weight: 900;
                    cursor: pointer;
                }
            }

            li:first-child {
                padding-left: 0;

                span:first-child {
                    padding-left: 12px
                }
            }

            li + li:before {
                /*color: #b5b5b5;*/
                content: "\0002f";
            }
        }
    }

    .search-form-container {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        margin-bottom: 10px;

        .search-button-container {
            width: 105px;
        }
    }


</style>
