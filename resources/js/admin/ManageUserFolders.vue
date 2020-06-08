<template>

    <b-row>


        <b-col cols="12" class="flex-container">
            <div style="display: inherit">
                <b-button class="new-folder mb-3" size="lg" @click="newFolderModal()" variant="success">
                    <i class="fas fa-plus "></i> new parent folder
                </b-button>
            </div>
            <b-modal
                id="parentFolderID" size="xl"
                title="add folder"
            >
                <div class="container-fluid">
                    <form enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control"
                                           v-model="newFolder.title">
                                </div>

                                <div class="form-group">
                                    <label>folder image</label>
                                    <input type="file" ref="file" @change="selectFolderFiles"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <template v-slot:modal-footer>
                    <b-button size="md" @click="addNewFolder()" variant="success">
                        <i class="fas fa-plus "></i> save
                    </b-button>
                </template>
            </b-modal>
            <div class="folder-parent-container mt-4">
                <folder-tree :currentFolders="userFolders" :taskList="this.taskList"></folder-tree>
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
        }
    }


</style>

<script>

    import axios from "axios";
    import FolderTree from "./FolderTree";


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
            FolderTree
        },
        methods: {
            addNewFolder() {
                const formData = new FormData();

                console.log(this.folderFile);
                formData.append('folderFile', this.folderFile);

                formData.append('folder', JSON.stringify(this.newFolder));


                axios.post('/folders/' + this.$route.params.id, formData).then(response => {

                    //add to
                    console.log(this.response);

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
