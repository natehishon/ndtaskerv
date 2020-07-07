<template>

    <div class="container-fluid">
        <form enctype="multipart/form-data" class="way-form">
            <b-row>

                <b-col xs="12" sm="6">
                    <div class="form-group">
                        <label for="title">task title</label>
                        <input type="text" class="form-control"
                               v-model="task.title">
                    </div>


                    <div class="form-group">
                        <label>task content</label>
                        <froala :tag="'textarea'" attribution="false"
                                key="nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2=="
                                :key="'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2=='"
                                :attribution="false" :config="{

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
                                                 }" v-model="task.content_html"></froala>

                    </div>


                    <b-button size="lg" @click="submitTask($event)" class="mb-3" variant="success">
                        save&nbsp;&nbsp;<i class="fas fa-save "></i>
                    </b-button>

                </b-col>

                <b-col xs="12" sm="6">
                    <div class="form-group">
                        <label>task media</label><br>
                        <!--                        <input type="file" ref="file" @change="selectTaskFiles"/>-->
                        <b-form-file
                            ref="file-input"
                            @change="selectTaskFiles"
                        ></b-form-file>
                    </div>


                    <div class="form-group">
                        <label>edit task steps</label><br>

                        <b-modal
                            id="modalNewID" size="xl"
                            title="create task step"
                        >
                            <div class="container-fluid">
                                <form enctype="multipart/form-data" class="way-form">
                                    <b-row>
                                        <b-col cols="10" offset-sm="1">
                                            <div class="form-group">
                                                <label for="title">task step title</label>
                                                <input type="text" class="form-control"
                                                       v-model="newSubTask.title">
                                            </div>
                                            <div class="form-group">
                                                <label>task step content</label>
                                                <froala :tag="'textarea'"
                                                        :key="'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2=='"
                                                        :attribution="false" :config="{
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
                                                        v-model="newSubTask.content_html"></froala>
                                            </div>

                                            <div class="form-group">
                                                <label>task step media</label><br>
                                                <input class="input-file" type="file" ref="file"
                                                       @change="selectSubTaskFiles"/>
                                            </div>
                                        </b-col>
                                    </b-row>
                                </form>
                            </div>

                            <template v-slot:modal-footer>
                                <b-button size="md" @click="newSubTaskAdded()" variant="success" class="large-button">
                                    <i class="fas fa-plus "></i> add
                                </b-button>
                            </template>
                        </b-modal>

                        <b-modal
                            id="modalEditID" size="xl"
                            title="edit task step"
                        >
                            <div class="container-fluid">
                                <form enctype="multipart/form-data" class="way-form">
                                    <b-row>
                                        <b-col cols="10" offset-sm="1">
                                            <div class="form-group">
                                                <label for="title">task step title</label>
                                                <input type="text" class="form-control"
                                                       v-model="editSubTask.title">
                                            </div>
                                            <div class="form-group">
                                                <label>task step content</label>
                                                <froala :tag="'textarea'"
                                                        :key="'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2=='"
                                                        :attribution="false" :config="{
                                                // key:'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2==',
                                                // apiKey:'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2==',

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
                                                        v-model="editSubTask.content_html"></froala>

                                            </div>

                                            <div class="form-group">
                                                <label>task step media</label><br>
                                                <input class="input-file" type="file" ref="file"
                                                       @change="selectEditSubTaskFiles"/>
                                            </div>
                                        </b-col>
                                    </b-row>
                                </form>
                            </div>

                            <template v-slot:modal-footer>
                                <b-button size="md" @click="subTaskEdited()" variant="success" class="large-button">
                                    <i class="fas fa-edit "></i> edit
                                </b-button>
                            </template>
                        </b-modal>

                        <b-button size="lg" @click="createSubTask()" class="" variant="primary">
                            new task step&nbsp;&nbsp;<i class="fas fa-plus "></i>
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
                            class="list-group-item cursor-pointer sub-task-container"
                            v-for="(element, index) in filteredSubs"
                            :key="index"
                        >

                            {{ element.title }}

                            <div>
                                <span class="handle" style="cursor: pointer">sort&nbsp;<i class="fas fa-arrows-alt"></i></span>
                                <b-dropdown no-caret variant="white" right>
                                    <template v-slot:button-content>
                                        <span style="font-size: 18px">options</span>
                                        &nbsp;<i class="fas fa-ellipsis-h" style="font-size: 18px;"></i>
                                    </template>
                                    <b-dropdown-item @click="editSubTasker(index)">edit task step&nbsp;&nbsp;<i
                                        class="fas fa-edit"></i></b-dropdown-item>
                                    <b-dropdown-item @click="deleteSubTask(index)">delete task step&nbsp;&nbsp;<i
                                        class="fas fa-trash"></i></b-dropdown-item>
                                </b-dropdown>
                            </div>

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
                    content_html: "",
                    fileKey: "",
                    file: "",
                    active: true
                },
                editSubTask: {
                    title: null,
                    content: "",
                    content_html: "",
                    fileKey: "",
                    file: "",
                    active: true
                },
                stripped: "",
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
                    htmlAllowedTags: ['.*'],
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

            // strippedContent(content) {
            //     let regex = /(<([^>]+)>)/ig;
            //     return content.replace(regex, "");
            // },

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
                    content_html: "",
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
            selectTaskFiles(event) {
                this.taskFile = event.target.files[0];
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

                console.log(this.task)

                event.preventDefault();
                const formData = new FormData();

                formData.append('taskFile', this.taskFile);

                if (this.task.sub_task) {
                    this.task.sub_task.forEach(function (value) {
                        formData.append(value.fileKey, value.file);
                    })
                }

                console.log(this.task);
                // this.task.content = this.strippedContent(this.task.content_html)

                formData.append('task', JSON.stringify(this.task));

                if (this.task.id) {
                    axios.post('tasks' + this.task.id, formData).then(response => {

                        this.task = response.data;

                    }).catch(err => {
                        console.log(err);
                    });
                } else {
                    axios.post('tasks', formData).then(response => {

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

<style lang="scss">
    .sub-task-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
