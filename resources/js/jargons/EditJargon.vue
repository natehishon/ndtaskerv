<template>

    <div class="container-fluid">
        <form enctype="multipart/form-data" class="way-form">
            <b-row>
                <b-col xs="12" sm="6">
                    <div class="form-group">
                        <label for="title">jargon title</label>
                        <input type="text" class="form-control"
                               v-model="jargon.title">
                    </div>


                    <div class="form-group">
                        <label>jargon content</label>
                        <froala :tag="'textarea'" :config="config"
                                :key="'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2=='"
                                :attribution="false" v-model="jargon.content_html"></froala>
                    </div>

                    <b-button size="lg" @click="check($event)" class="mb-3" variant="success">
                        <i class="fas fa-save "></i>&nbsp;&nbsp;save
                    </b-button>

                </b-col>
                <b-col xs="12" sm="6">

                    <div class="form-group">
                        <div class="media-container">
                            <label>jargon media</label>
                            <div class="large-font">jargon file: {{ file ? file.name : jargon.filename }}</div>
                        </div>
                        <b-form-file
                            ref="file-input"
                            @change="onSelect"
                        ></b-form-file>
                    </div>

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
                    toolbarButtons: ['paragraphFormat', 'bold', 'italic', 'strikeThrough', 'textColor', 'formatOL', 'formatUL', 'clearFormatting', 'link', 'unlink', 'myButton', 'image', 'blockquote',],
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
            onSelect(event) {
                this.file = event.target.files[0];
            },
            check(event) {
                event.preventDefault();
                const formData = new FormData();
                formData.append('image', this.file);
                for (let property in this.jargon) {
                    formData.append(property, this.jargon[property]);
                }

                console.log(formData);
                axios.post('jargons/' + this.jargon.id, formData).then(response => {
                    this.$refs['successModal'].show()
                }).catch(err => {
                    console.log(err);
                });


            }
        }

    }

</script>

<style lang="scss">
    .media-container{
        display: flex;
        justify-content: space-between;
    }
</style>
