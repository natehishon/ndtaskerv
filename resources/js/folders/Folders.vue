<template>



    <div class="folder-table mt-4">

        <b-table
                :items="folders"
                :fields="fields"
                ref="selectableTable"
                @row-clicked="choose"
                responsive="sm"
                :tbody-tr-class="rowClass"></b-table>

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
                    {key: 'title', sortable: true},
                    {key: 'type', sortable: true},
                ],
                task: {id: "0", title:"", sub_task:[]},
                currentSlide: 0,
            }
        },
        methods: {
            choose(row) {

                if(row.type === 'Task'){
                    this.task = row;
                    console.log("task")
                    console.log(this.task)
                    this.$bvModal.show("modalID");
                }

                if(row.type === 'Folder'){
                    this.$router.push(this.$router.currentRoute.path + '/' + row.title  )
                }

                // this.$refs.selectableTable.clearSelected()

                // this.$router.push(this.$router.currentRoute.path + '/' + row[0].name)
            },
            changeSlide(event) {
                this.currentSlide = event
            }
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

            axios.get('/folders' + path).then(response => {

                console.log(response.data);
                this.folders = response.data.table;
                this.task = this.folders[1];


            }).catch(err => {
                console.log(err);
            });
        }

    }

</script>