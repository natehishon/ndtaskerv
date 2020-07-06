<template>

    <div class="container-fluid">
        <form enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control"
                               v-model="jargon.title">
                    </div>


                    <div class="form-group">
                        <label>Content</label>
                        <froala :tag="'textarea'" :config="config" :key="'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2=='" :attribution="false" v-model="jargon.content_html"></froala>
                    </div>

                    <div class="form-group">
                        <label>jargon image</label>
                        <input type="file" ref="file" @change="onSelect"/>
                    </div>


                    <button class="btn btn-secondary btn-block" @click="check($event)">Save</button>
                </div>
            </div>
        </form>
    </div>


</template>

<script>

    import axios from 'axios';
    import Jargon from '../jargons/Jargon';
    import VRuntimeTemplate from "v-runtime-template";
    import draggable from 'vuedraggable'

    export default {
        components:{
            Jargon,
            VRuntimeTemplate,
            draggable
        },
        data() {
            return {
                jargon: null,
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
                }
            }
        },
        // props: ['id'],
        mounted() {
            axios.get('/jargons/' + this.$route.params.id).then(response => {
                console.log(response)
                this.jargon = response.data.data;
            }).catch(err => {

                },
            )
        }
        ,
        methods: {
            onSelect() {
                this.file = this.$refs.file.files[0];
            },
            check(event) {
                event.preventDefault();
                const formData = new FormData();
                formData.append('image', this.file);
                console.log(this.jargon)
                for (let property in this.jargon) {
                    formData.append(property, this.jargon[property]);
                }

                console.log(formData);
                axios.post('jargons/' + this.jargon.id, formData).then(response => {
                    console.log(response)
                }).catch(err => {
                    console.log(err);
                });


            }
        }

    }

</script>
