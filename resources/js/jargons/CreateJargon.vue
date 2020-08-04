<template>

    <div class="container-fluid">
        <form enctype="multipart/form-data" class="way-form">

            <b-row>
                <b-col xs="12" sm="6">

                    <div class="form-group">
                        <label for="title">jargon title</label>
                        <input type="text" class="form-control"
                               v-model="newJargon.title">
                    </div>

                    <div class="form-group">
                        <label>jargon content</label>
                        <froala :tag="'textarea'"
                                :key="'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2=='"
                                :attribution="false" :config="config" v-model="newJargon.content_html"></froala>
                    </div>


                    <b-button size="lg" @click="check($event)" class="mb-3" variant="success">
                        <i class="fas fa-save "></i>&nbsp;&nbsp;save
                    </b-button>
                </b-col>
                <b-col xs="12" sm="6">
                    <div class="form-group">
                        <label>jargon media</label><br>
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
                // file: "",
                newJargon: {
                    title: "",
                    // content: "",
                    content_html: '',
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
                    toolbarButtons: ['paragraphFormat', 'bold', 'italic', 'strikeThrough', 'textColor', 'formatOL', 'formatUL', 'clearFormatting', 'link', 'unlink', 'myButton', 'image', 'blockquote',],
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
                return '<div>' + this.newJargon.content_html + '</div>'
            }
        },

        methods: {

            created() {
            },

            onSelect(event) {
                this.file = event.target.files[0];
            },

            addJargon($event) {
                $event.preventDefault();
                this.newJargon.content_html = this.newJargon.content_html + ' <jargon></jargon> '
                console.log(this.newJargon.content_html);
            },

            check(event) {

                event.preventDefault();

                const formData = new FormData();
                formData.append('image', this.file);
                for (let property in this.newJargon) {
                    formData.append(property, this.newJargon[property]);
                }



                axios.post('jargons', formData).then(response => {

                    this.$refs['successModal'].show()
                }).catch(err => {
                    console.log(err);
                });


            }
        }


    }

</script>
