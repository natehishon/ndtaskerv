<template>

    <div class="container-fluid">
        <form enctype="multipart/form-data" class="way-form">
            <b-row>

                <b-col xs="12" sm="6">
                    <div class="form-group">
                        <label for="title">title</label>
                        <input type="text" class="form-control"
                               v-model="task.title">
                    </div>


                    <div class="form-group">
                        <label>content</label>
                        <froala :tag="'textarea'" :config="config" v-model="task.content"></froala>
                    </div>


                    <b-button size="lg" @click="submitTask($event)" class="mb-3" variant="success">
                        <i class="fas fa-save "></i> save
                    </b-button>
                    <!--                    <button class="btn btn-secondary btn-block" @click="check($event)">Save</button>-->

                </b-col>

                <b-col xs="12" sm="6">
                    <div class="form-group">
                        <label>task media</label><br>
<!--                        <input type="file" ref="file" @change="selectTaskFiles"/>-->
                        <b-form-file
                            ref="file"
                        ></b-form-file>
                    </div>


                    <div class="form-group">
                        <label>edit sub tasks</label><br>

                        <b-modal
                            id="modalNewID" size="xl"
                            title="create subtask"
                        >
                            <div class="container-fluid">
                                <form enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control"
                                                       v-model="newSubTask.title">
                                            </div>
                                            <div class="form-group">
                                                <label>Content</label>
                                                <froala :tag="'textarea'" :config="{
                                                colorsStep: 6,
                                                colorsText: [
                                                    '#15E67F', '#E3DE8C', '#D8A076', '#D83762', '#76B6D8', 'REMOVE',
                                                    '#1C7A90', '#249CB8', '#4ABED9', '#FBD75B', '#FBE571', '#FFFFFF'
                                                ],
                                                quickInsertTags: [],
                                                toolbarButtons: ['paragraphFormat', 'bold', 'italic', 'strikeThrough', 'textColor', 'formatOL', 'formatUL', 'clearFormatting', 'link', 'unlink', 'myButton', 'image', 'blockquote', 'html'],
                                                paragraphFormatSelection: true,
                                                refreshAfterCallback: true,
                                                htmlUntouched: true,
                                                htmlAllowedTags: ['.*', 'jargon'],
                                                htmlRemoveTags: ['']
                                                 }"
                                                        v-model="newSubTask.content"></froala>
                                            </div>

                                            <div class="form-group">
                                                <label>Sub Task Image</label>
                                                <input type="file" ref="file" @change="selectSubTaskFiles"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <template v-slot:modal-footer>
                                <b-button size="md" @click="newSubTaskAdded()" variant="success">
                                    <i class="fas fa-plus "></i> add
                                </b-button>
                            </template>
                        </b-modal>

                        <b-modal
                            id="modalEditID" size="xl"
                            title="edit subtask"
                        >
                            <div class="container-fluid">
                                <form enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control"
                                                       v-model="editSubTask.title">
                                            </div>
                                            <div class="form-group">
                                                <label>Content</label>
                                                <froala :tag="'textarea'" :config="{
                                                colorsStep: 6,
                                                colorsText: [
                                                    '#15E67F', '#E3DE8C', '#D8A076', '#D83762', '#76B6D8', 'REMOVE',
                                                    '#1C7A90', '#249CB8', '#4ABED9', '#FBD75B', '#FBE571', '#FFFFFF'
                                                ],
                                                quickInsertTags: [],
                                                toolbarButtons: ['paragraphFormat', 'bold', 'italic', 'strikeThrough', 'textColor', 'formatOL', 'formatUL', 'clearFormatting', 'link', 'unlink', 'myButton', 'image', 'blockquote', 'html'],
                                                paragraphFormatSelection: true,
                                                refreshAfterCallback: true,
                                                htmlUntouched: true,
                                                htmlAllowedTags: ['.*', 'jargon'],
                                                htmlRemoveTags: ['']
                                                 }"
                                                        v-model="editSubTask.content"></froala>
                                            </div>

                                            <div class="form-group">
                                                <label>Sub Task Image</label>
                                                <input type="file" ref="file" @change="selectEditSubTaskFiles"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <template v-slot:modal-footer>
                                <b-button size="md" @click="subTaskEdited()" variant="success">
                                    <i class="fas fa-plus "></i> add
                                </b-button>
                            </template>
                        </b-modal>

                        <b-button size="lg" @click="createSubTask()" class="mb-3" variant="primary">
                            <i class="fas fa-plus "></i> new sub task
                        </b-button>

                    </div>

                    <draggable
                        v-if="task.sub_task"
                        :list="task.sub_task"
                        class="list-group"
                        ghost-class="ghost"
                        handle=".handle"


                    >
                        <div
                            class="list-group-item cursor-pointer"
                            v-for="(element, index) in filteredSubs"
                            :key="index"
                        >
                            {{ element.title }}

                            <i class="fas fa-arrows-alt handle"></i>
                            <b-button size="lg" @click="editSubTasker(index)" variant="info">
                                <i class="fas fa-plus "></i> edit sub task
                            </b-button>
                            <b-button size="lg" @click="deleteSubTask(index)" variant="danger">
                                <i class="fas fa-plus "></i> delete sub task
                            </b-button>
                        </div>
                    </draggable>

                </b-col>

            </b-row>
        </form>


        <success-modal :id="'successID'" :uniqueId="'successModalID'" :ref="'successModal'"></success-modal>
    </div>


</template>

<script>

    import axios from 'axios';
    import Jargon from '../jargons/Jargon';
    import VRuntimeTemplate from "v-runtime-template";
    import draggable from 'vuedraggable'
    import SuccessModal from "../miscellaneous/SuccessModal";

    export default {
        components: {
            Jargon,
            VRuntimeTemplate,
            draggable,
            SuccessModal
        },
        computed: {
            filteredSubs: function () {
                return this.task.sub_task.filter(i => i.active !== false)
            },
        },
        data() {
            return {
                task: {
                    sub_task: []
                },
                newSubTask: {
                    title: null,
                    content: "",
                    fileKey: "",
                    file: "",
                    active: true
                },
                editSubTask: {
                    title: null,
                    content: "",
                    fileKey: "",
                    file: "",
                    active: true
                },
                taskFile: "",
                subTaskFiles: [],
                template: `<jargon></jargon>`,
                config: {
                    colorsStep: 6,
                    colorsText: [
                        '#15E67F', '#E3DE8C', '#D8A076', '#D83762', '#76B6D8', 'REMOVE',
                        '#1C7A90', '#249CB8', '#4ABED9', '#FBD75B', '#FBE571', '#FFFFFF'
                    ],
                    quickInsertTags: [],
                    toolbarButtons: ['paragraphFormat', 'bold', 'italic', 'strikeThrough', 'textColor', 'formatOL', 'formatUL', 'clearFormatting', 'link', 'unlink', 'myButton', 'image', 'blockquote', 'html'],
                    paragraphFormatSelection: true,
                    refreshAfterCallback: true,
                    htmlUntouched: true,
                    htmlAllowedTags: ['.*', 'jargon'],
                    htmlRemoveTags: ['']
                }
            }
        },
        // props: ['id'],
        methods: {
            subTaskEdited() {
                if (this.editSubTask.file) {
                    let date = new Date();
                    let currentMilli = date.getTime();
                    this.subTaskFiles.push({
                        subTaskFileKey: currentMilli.toString(),
                        file: this.$refs.file.files[0]
                    })
                    this.editSubTask.fileKey = currentMilli.toString();
                }
                this.$bvModal.hide("modalEditID");
            },
            newSubTaskAdded() {

                if (this.newSubTask.file) {
                    let date = new Date();
                    let currentMilli = date.getTime();
                    this.subTaskFiles.push({
                        subTaskFileKey: currentMilli.toString(),
                        file: this.$refs.file.files[0]
                    })
                    this.newSubTask.fileKey = currentMilli.toString();
                }

                this.task.sub_task.push(this.newSubTask)
                this.newSubTask = {
                    title: null,
                    content: "",
                    fileKey: "",
                    file: "",
                    active: true
                }
                this.$bvModal.hide("modalNewID");
            },
            createSubTask() {
                this.$bvModal.show("modalNewID");
            },
            editSubTasker(index) {
                this.$bvModal.show("modalEditID");
                this.editSubTask = this.task.sub_task[index];
            },
            selectTaskFiles() {
                this.taskFile = this.$refs.file.files[0];
            },
            selectSubTaskFiles() {
                this.newSubTask.file = this.$refs.file.files[0];
            },
            selectEditSubTaskFiles() {
                this.editSubTask.file = this.$refs.file.files[0];
            },
            deleteSubTask(index) {
                this.task.sub_task[index].active = false;
            },
            submitTask(event) {
                event.preventDefault();
                const formData = new FormData();

                formData.append('taskFile', this.taskFile);

                if (this.task.sub_task) {
                    this.task.sub_task.forEach(function (value) {
                        formData.append(value.fileKey, value.file);
                    })
                }


                formData.append('task', JSON.stringify(this.task));

                if (this.task.id) {
                    axios.post('/tasks/' + this.task.id, formData).then(response => {

                        this.task = response.data;

                    }).catch(err => {
                        console.log(err);
                    });
                } else {
                    axios.post('/tasks/', formData).then(response => {

                        this.task = response.data;

                    }).catch(err => {
                        console.log(err);
                    });
                }

                this.$refs['successModal'].show()


            }
        }

    }

</script>
