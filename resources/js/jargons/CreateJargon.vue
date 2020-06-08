<template>

    <b-row>
        <b-col cols="12">

            <form enctype="multipart/form-data">

                <!--                <h1>create a task</h1>-->

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control"
                           v-model="newJargon.title">
                </div>


                <div class="form-group">
                    <label>Content</label>
                    <froala :tag="'textarea'" :config="config" v-model="newJargon.content"></froala>
                </div>

                <div class="form-group">
                    <label>Task Image</label>
                    <input type="file" ref="file" @change="onSelect"/>
                </div>

                <button class="btn btn-secondary btn-block" @click="check($event)">Save</button>

                <br>
                <!--                <div class="form-group">-->
                <!--                    <label>edit sub tasks</label>-->
                <!--                </div>-->

                <!--                <draggable-->
                <!--                    :list="myArray"-->
                <!--                    class="list-group"-->
                <!--                    ghost-class="ghost"-->
                <!--                >-->
                <!--                    <div-->
                <!--                        class="list-group-item"-->
                <!--                        v-for="element in myArray"-->
                <!--                        :key="element.name"-->
                <!--                    >-->
                <!--                        {{ element.name }}-->
                <!--                    </div>-->
                <!--                </draggable>-->

            </form>
        </b-col>
    </b-row>


</template>

<script>

    import axios from 'axios';
    import Jargon from '../jargons/Jargon';
    import VRuntimeTemplate from "v-runtime-template";
    import draggable from 'vuedraggable'


    export default {

        components: {
            Jargon,
            VRuntimeTemplate,
            draggable
        },

        data() {
            return {
                // file: "",
                newJargon: {
                    title: "",
                    // content: "",
                    content: '',
                },
                file: "",
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
                },
                // model: 'Edit Your Content Here!'
            }
        },

        computed: {
            // a computed getter
            taskTemplate: function () {
                // `this` points to the vm instance
                return '<div>' + this.newJargon.content + '</div>'
            }
        },

        methods: {

            created() {
            },

            onSelect() {
                const file = this.$refs.file.files[0];;
                this.file = file;
            },

            addJargon($event) {
                $event.preventDefault();
                this.newJargon.content = this.newJargon.content + ' <jargon></jargon> '
                console.log(this.newJargon.content);
            },

            check(event) {

                event.preventDefault();

                const formData = new FormData();
                formData.append('image', this.file);
                for (let property in this.newJargon) {
                    console.log(property);
                    console.log(this.newJargon[property]);
                    formData.append(property, this.newJargon[property]);
                }

                console.log(formData);

                axios.post('/jargons', formData).then(response => {
                    console.log(response)
                }).catch(err => {
                    console.log(err);
                });


            }
        }


    }

</script>
