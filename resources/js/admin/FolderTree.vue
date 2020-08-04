<template>


    <div class="user-folder-tree-container">

        <ul>
            <li v-for="folder in currentFolders" class="folder-container">

                <span class="folder" v-b-toggle="'folder' + folder.id">
                    <span class="when-opened">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </span>
                    <span class="when-closed">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </span>
                    <b-badge variant="primary" class="mr-1">
                        <i class="fas fa-folder fa-fw"></i>&nbsp;folder
                    </b-badge>
                    {{folder.title}}
                </span>
                <b-dropdown no-caret variant="light">
                    <template v-slot:button-content>
                        <i class="fas fa-ellipsis-h" style="font-size: 18px;"></i>&nbsp;&nbsp;<span
                        style="font-size: 18px">edit</span>
                    </template>
                    <b-dropdown-item @click="newChildFolderModal(folder)">
                        <i class="far fa-folder"></i>&nbsp;add folder
                    </b-dropdown-item>
                    <b-dropdown-item @click="newChildTask(folder)">
                        <i class="fas fa-list"></i>&nbsp;add task
                    </b-dropdown-item>
                    <b-dropdown-item @click="deleteFolder(folder)">
                        <i class="fas fa-trash"></i>&nbsp;delete
                    </b-dropdown-item>
                </b-dropdown>
                <b-collapse :id="'folder'+folder.id" class="folder-tree-ul ">
                    <ul v-if="folder.task_trackings" style="padding-left: 24px">
                        <li v-for="taskTracking in folder.task_trackings">
                            <span class="task mb-2">
                                <b-badge variant="info" class="mr-1">
                                    <i class="fas fa-list fa-fw"></i>&nbsp;task
                                </b-badge>
                            {{taskTracking.tasks.title}}
                            </span>
                            <b-dropdown no-caret variant="light">
                                <template v-slot:button-content>
                                    <i class="fas fa-ellipsis-h" style="font-size: 18px;"></i>&nbsp;&nbsp;<span
                                    style="font-size: 18px">edit</span>
                                </template>
                                <b-dropdown-item @click="deleteTracking(taskTracking)"><i
                                    class="fas fa-trash"></i>&nbsp;delete</b-dropdown-item>
                            </b-dropdown>
                        </li>
                    </ul>
                    <folder-tree :current-folders="folder.childrens_children" :task-list="taskList"
                                 v-if="folder.childrens_children" :refresh-folders="refreshFolders"></folder-tree>

                </b-collapse>
                <b-modal
                    :id="'childFolder' + folder.id" size="xl"
                    title="add folder"
                >
                    <div class="container-fluid">
                        <form enctype="multipart/form-data" class="way-form">
                            <b-row>
                                <b-col cols="10" offset-sm="1">
                                    <div class="form-group">
                                        <label for="title">folder title</label>
                                        <input type="text" class="form-control"
                                               v-model="newFolder.title">
                                    </div>

                                    <div class="form-group">
                                        <label>folder image</label><br>
                                        <input class="input-file" type="file" ref="folderFile"
                                               @change="selectFolderFiles"/>
                                    </div>
                                </b-col>
                            </b-row>
                        </form>
                    </div>

                    <template v-slot:modal-footer>
                        <b-button size="md" @click="addNewFolder(folder)" variant="success" class="large-button">
                            <i class="fas fa-plus "></i> save
                        </b-button>
                    </template>
                </b-modal>
                <b-modal
                    :id="'childTask' + folder.id" size="xl"
                    title="add task"
                >
                    <div class="container-fluid">
                        <form enctype="multipart/form-data" class="way-form">
                            <b-row>
                                <b-col cols="10" offset-sm="1">
                                    <div class="form-group">
                                        <label for="title">task picker</label>
                                        <vue-bootstrap-typeahead
                                            v-model="selectedTask"
                                            :data="taskList"
                                            :serializer="s => s.title"
                                            @hit="selectedAddress = $event"
                                        />
                                    </div>
                                </b-col>
                            </b-row>
                        </form>
                    </div>

                    <template v-slot:modal-footer>
                        <b-button size="md" @click="addNewTask(folder)" variant="success" class="large-button">
                            <i class="fas fa-plus "></i> save
                        </b-button>
                    </template>
                </b-modal>
                <success-modal :id="'successID' + folder.id" :uniqueId="folder.id"
                               :ref="'successModal'+folder.id"></success-modal>
            </li>
        </ul>


    </div>


</template>

<style lang="scss">


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


</style>

<script>


    import axios from "axios";
    import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
    import SuccessModal from "../miscellaneous/SuccessModal";

    export default {
        name: 'folderTree',
        data() {
            return {
                newFolder: {},
                selectedTask: null,
                selectedAddress: null
            }
        },
        props: ['currentFolders', 'taskList', 'refreshFolders'],
        components: {
            VueBootstrapTypeahead,
            SuccessModal
        },
        methods: {
            addNewTask(folder) {
                let postData = {
                    taskID: this.selectedAddress.id,
                    folderID: folder.id
                }
                axios.post('trackings/' + this.$route.params.id, postData).then(response => {

                    //add to
                    this.refreshFolders();

                }).catch(err => {
                    console.log(err);
                });
                this.selectedAddress = null;
                let obName = "successModal" + folder.id;
                let ref = this.$refs[obName];
                this.$bvModal.hide("childTask" + folder.id);
                ref[0].show()
            },
            addNewFolder(folder) {
                const formData = new FormData();

                formData.append('folderFile', this.folderFile);

                formData.append('folder', JSON.stringify(this.newFolder));


                axios.post('folders/' + this.$route.params.id, formData).then(response => {

                    //add to
                    // this.currentFolders = response.data.folders;
                    // this.taskList = response.data.tasks;


                    this.refreshFolders();
                    let obName = "successModal" + folder.id;
                    let ref = this.$refs[obName];
                    //:id="'childFolder' + folder.id
                    this.$bvModal.hide("childFolder" + folder.id);
                    ref[0].show()

                }).catch(err => {
                    console.log(err);
                });

            },
            newChildFolderModal(folder) {

                this.newFolder = {
                    isTopLevel: false,
                    parent_id: folder.id,
                    title: null
                }

                this.$bvModal.show("childFolder" + folder.id);
            },
            newChildTask(folder) {
                this.newTaskTracking = {
                    folder_id: folder.id,
                }

                this.$bvModal.show("childTask" + folder.id);
            },
            selectFolderFiles() {
                this.folderFile = this.$refs.folderFile[0].files[0];
            },
            deleteTracking(tracking) {
                axios.delete('/trackings/' + tracking.id).then(response => {

                    //add to

                }).catch(err => {
                    console.log(err);
                });
            },
            deleteFolder(folder) {
                axios.delete('/folders/' + folder.id).then(response => {

                    //add to

                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }

</script>
