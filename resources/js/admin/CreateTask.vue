<template>

    <b-row>
        <b-col cols="12">

            <form enctype="multipart/form-data">

                <h1>create a task</h1>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control"
                           v-model="newTask.title">
                </div>


                <div class="form-group">
                    <label>Content</label>
                    <froala :tag="'textarea'" :config="config" v-model="newTask.content"></froala>
                </div>

                <div class="form-group">
                    <label>Task Image</label>
                    <input type="file" ref="file" @change="onSelect"/>
                </div>

                <button class="btn btn-secondary btn-block" @click="check($event)">Save</button>

                <div class="form-group">
                    <label>edit sub tasks</label>
                </div>

                <v-runtime-template :template="taskTemplate"/>

            </form>
        </b-col>
    </b-row>


</template>

<script>

    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import axios from 'axios';
    import jargon from '../jargons/jargon';
    import VRuntimeTemplate from "v-runtime-template";
    // import VAButton from 'vue2-admin-lte/src/components/VAButton.vue'
    // import Modal from 'vue2-admin-lte/src/components/Modal';
    // import RemoveFormat from '@ckeditor/ckeditor5-remove-format/src/removeformat';
    import VueFroala from 'vue-froala-wysiwyg';


    export default {

        components: {
            // 'va-button': VAButton,
            // 'va-modal': Modal
            jargon,
            VRuntimeTemplate
        },

        data() {
            return {
                // file: "",
                newTask: {
                    title: "title",
                    // content: "",
                    content: '<p>Content of the editor <jargon>jargon</jargon> more more <jargon>invoicing</jargon> </p>',
                },
                file: "",
                yo: "yo",
                editor: ClassicEditor,
                showLargeModal: false,
                template: `<jargon></jargon>`,
                config: {
                    colorsStep: 6,
                    colorsText: [
                        '#15E67F', '#E3DE8C', '#D8A076', '#D83762', '#76B6D8', 'REMOVE',
                        '#1C7A90', '#249CB8', '#4ABED9', '#FBD75B', '#FBE571', '#FFFFFF'
                    ],
                    events: {
                        'froalaEditor.initialized': function () {
                            console.log('initialized')
                        }
                    },
                    quickInsertTags: [],
                    toolbarButtons: ['paragraphFormat', 'bold', 'italic', 'strikeThrough', 'textColor', 'formatOL', 'formatUL', 'clearFormatting', 'link', 'unlink', 'myButton', 'image', 'blockquote', 'html'],
                    // htmlAllowedStyleProps: ['font-family', 'font-size', 'background', 'color', 'width', 'text-align', 'vertical-align', 'background-color', 'float'],
                    paragraphFormatSelection: true,
                    refreshAfterCallback: true,
                    htmlUntouched: true,
                    // imageEditButtons: ['replaceImage', 'imageDisplay', 'imageAlign', 'imageRemove'],
                    // linkEditButtons: ['linkOpen', 'linkRemove'],
                    // linkNoReferrer: false,
                    htmlAllowedTags: ['.*', 'jargon'],
                    htmlRemoveTags: ['']
                },
                // model: 'Edit Your Content Here!'
            }
        },

        computed: {
            // a computed getter
            taskTemplate: function () {
                // `this` points to the vm instance
                return '<div>' + this.newTask.content + '</div>'
            }
        },

        methods: {

            created() {
                // this.loading = true;
                //
                // const request = axios.get("jargons").then(response => {
                //     console.log(response);
                //     this.loading = false;
                // })
            },

            onSelect() {
                const file = this.$refs.file.files[0];
                console.log(file);
                this.file = file;
            },

            addJargon($event) {
                $event.preventDefault();
                this.newTask.content = this.newTask.content + ' <jargon></jargon> '
                console.log(this.newTask.content);
            },

            check(event) {

                event.preventDefault();

                const formData = new FormData();
                formData.append('image', this.file);
                for (let property in this.newTask) {
                    console.log(property);
                    console.log(this.newTask[property]);
                    formData.append(property, this.newTask[property]);
                }

                console.log(formData);

                axios.post('/tasks', formData).then(response => {
                    console.log(response)
                }).catch(err => {
                    console.log(err);
                });


            }
        }


    }

</script>