<template>

    <div class="prebuilt-parent-container">
        <div class="user-folder-tree-container">
            <div class="folder-container">
                <span class="folder">
                    <b-badge variant="primary" class="mr-1">folder&nbsp;&nbsp;<i
                        class="fas fa-folder fa-fw"></i></b-badge>
                    {{prebuiltFolder.title}}
                </span>
                <b-dropdown no-caret variant="light">
                    <template v-slot:button-content>
                        <i class="fas fa-ellipsis-h" style="font-size: 18px;"></i>&nbsp;&nbsp;<span
                        style="font-size: 18px">edit</span>
                    </template>
                    <b-dropdown-item @click="newTask()">add task&nbsp;&nbsp;<i class="fas fa-list"></i>
                    </b-dropdown-item>
                </b-dropdown>
                <!--            <b-collapse :id="'folder'+folder.id" class="folder-tree-ul ">-->
                <ul v-if="prebuiltFolder.tasks">
                    <li v-for="task in prebuiltFolder.tasks">
                            <span class="task mb-2">
                                <b-badge variant="info" class="mr-1">
                                    task&nbsp;&nbsp;<i class="fas fa-list fa-fw"></i>
                                </b-badge>
                            {{task.title}}
                            </span>
                        <b-dropdown no-caret variant="light">
                            <template v-slot:button-content>
                                <i class="fas fa-ellipsis-h" style="font-size: 18px;"></i>&nbsp;&nbsp;<span
                                style="font-size: 18px">edit</span>
                            </template>
                            <b-dropdown-item @click="deleteTracking(taskTracking)">delete&nbsp;&nbsp;<i
                                class="fas fa-trash"></i></b-dropdown-item>
                        </b-dropdown>
                    </li>
                </ul>
                <!--                <folder-tree :current-folders="folder.childrens_children" :task-list="taskList"-->
                <!--                             v-if="folder.childrens_children"></folder-tree>-->

                <!--            </b-collapse>-->
                <!--            <b-modal-->
                <!--                :id="'childFolder' + folder.id" size="xl"-->
                <!--                title="add folder"-->
                <!--            >-->
                <!--                <div class="container-fluid">-->
                <!--                    <form enctype="multipart/form-data">-->
                <!--                        <div class="row">-->
                <!--                            <div class="col-xs-12">-->
                <!--                                <div class="form-group">-->
                <!--                                    <label for="title">Title</label>-->
                <!--                                    <input type="text" class="form-control"-->
                <!--                                           v-model="newFolder.title">-->
                <!--                                </div>-->

                <!--                                <div class="form-group">-->
                <!--                                    <label>folder image</label>-->
                <!--                                    <input type="file" ref="folderFile" @change="selectFolderFiles"/>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </form>-->
                <!--                </div>-->

                <!--                <template v-slot:modal-footer>-->
                <!--                    <b-button size="md" @click="addNewFolder()" variant="success">-->
                <!--                        <i class="fas fa-plus "></i> save-->
                <!--                    </b-button>-->
                <!--                </template>-->
                <!--            </b-modal>-->
                <b-modal
                    :id="'childTask'" size="xl"
                    title="add task"
                >
                    <div class="container-fluid">
                        <form enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="title">task picker</label>
                                        <vue-bootstrap-typeahead
                                            v-model="selectedTask"
                                            :data="taskList"
                                            :serializer="s => s.title"
                                            @hit="selectedAddress = $event"
                                        />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <template v-slot:modal-footer>
                        <b-button size="md" @click="addNewTask()" variant="success">
                            <i class="fas fa-plus "></i> save
                        </b-button>
                    </template>
                </b-modal>
                <!--            <success-modal :id="'successID' + folder.id" :uniqueId="folder.id" :ref="'successModal'+folder.id"></success-modal>-->
            </div>
        </div>
    </div>
</template>

<style>


</style>

<script>


    import axios from "axios";
    import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'

    export default {
        name: 'prebuiltFolder',
        data() {
            return {
                prebuiltFolder: null,
                selectedTask: null,
                taskList: null,
            }
        },
        components: {
            VueBootstrapTypeahead,
        },
        methods: {

            newTask(folder) {
                this.$bvModal.show("childTask");
            },
            addNewTask() {
                let postData = {
                    taskID: this.selectedAddress.id,
                }
                axios.post('/prebuilt-folders-task/' + this.$route.params.id, postData).then(response => {

                    //add to
                    console.log(this.response);

                }).catch(err => {
                    console.log(err);
                });
                this.selectedAddress = null;
                // let obName = "successModal"+ folder.id;
                // let ref = this.$refs[obName];
                this.$bvModal.hide("childTask");
                // ref[0].show()
            }
        },
        mounted() {
            axios.get('/prebuilt-folders/' + this.$route.params.id).then(response => {
                console.log(response.data)
                this.prebuiltFolder = response.data.prebuiltFolder;
                this.taskList = response.data.tasks;
                console.log(this.prebuiltFolder);
            }).catch(err => {

                },
            )
        }
    }

</script>

<style lang="scss">
    .prebuilt-parent-container{

        display: flex;
        justify-content: center;

        .user-folder-tree-container {

            display: flex;
            justify-content: left;


            .folder-tree-ul {
                border-left: 5px solid rgba(0, 0, 0, 0.05);
            }

            ul {
                list-style: none;

                li {
                    cursor: pointer;
                }
            }

            font-size: 25px;

        }
    }

</style>
