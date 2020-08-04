<template>

    <b-row>


        <b-col cols="12" class="flex-container">
            <div style="display: inherit">
                <b-button class="new-folder mb-3" size="lg" @click="newFolderModal()" variant="success">
                    <i class="fas fa-plus "></i>&nbsp;new parent folder
                </b-button>
            </div>
            <b-modal
                id="parentFolderID" size="xl"
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
                                    <input class="input-file" type="file" ref="file" @change="selectFolderFiles"/>
                                </div>
                            </b-col>
                        </b-row>
                    </form>
                </div>

                <template v-slot:modal-footer >
                    <b-button size="md" @click="addNewFolder()" variant="success" class="large-button">
                        <i class="fas fa-plus "></i>&nbsp;save
                    </b-button>
                </template>
            </b-modal>
            <success-modal id="parentFolderSuccessId" :uniqueId="'parentFolderSuccessId'" :ref="'parentFolderSuccessId'"></success-modal>
            <div class="folder-parent-container">
                <folder-tree :currentFolders="userFolders" :refresh-folders="refreshFolders" :taskList="this.taskList"></folder-tree>
            </div>
        </b-col>
    </b-row>

</template>

<style lang="scss">

    .flex-container {
        display: flex;
        flex-direction: column;
        justify-content: center;

        .new-folder {
            margin: 0 auto;
        }

        /*text-align: center;*/
        .folder-parent-container {
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            justify-content: center;
            margin: 10px auto;
        }
    }


</style>

<script>

    import axios from "axios";
    import FolderTree from "./FolderTree";
    import SuccessModal from "../miscellaneous/SuccessModal";


    export default {
        name: 'userFolders',
        data() {
            return {
                userFolders: null,
                taskList: null,
                newFolder: {},
                folderFile: ""
            }
        },
        components: {
            FolderTree,
            SuccessModal
        },
        methods: {
            addNewFolder() {
                const formData = new FormData();

                formData.append('folderFile', this.folderFile);
                formData.append('folder', JSON.stringify(this.newFolder));

                axios.post('folders/' + this.$route.params.id, formData).then(response => {
                    //add to
                    this.userFolders = response.data.folders;
                    this.taskList = response.data.tasks;
                    this.refreshFolders();

                    //show success and close
                    this.$bvModal.hide("parentFolderID");
                    // this.$bvModal.show("parent-folder-success-id");

                    this.$refs.parentFolderSuccessId.show();
                }).catch(err => {
                    console.log(err);
                });

            },
            newFolderModal() {

                this.newFolder = {
                    isTopLevel: true,
                    title: null
                }

                this.$bvModal.show("parentFolderID");
            },
            selectFolderFiles() {
                this.folderFile = this.$refs.file.files[0];
            },
            refreshFolders(){
                axios.get("user-folders/" + this.$route.params.id).then(response => {
                    this.userFolders = response.data.folders;
                    this.taskList = response.data.tasks;
                    // this.loading = false;
                })
            }
        },
        mounted() {
            const request = axios.get("user-folders/" + this.$route.params.id).then(response => {
                this.userFolders = response.data.folders;
                this.taskList = response.data.tasks;
                // this.loading = false;
            })
        }
    }

</script>
