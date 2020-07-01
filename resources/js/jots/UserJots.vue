<template>

    <div class="">

        <b-button size="lg" @click="comment()" class="mb-3" variant="success">
            <i class="fas fa-plus "></i> comment
        </b-button>

        <b-modal
            id="userJot" size="xl"
            title="add comment"
        >
            <div class="container-fluid">
                <form enctype="multipart/form-data" class="way-form">
                    <b-row>

                        <b-col xs="10">
                            <div class="form-group">
                                <froala :tag="'textarea'" :config="{

                    colorsStep: 6,
                    colorsText: [
                        '#15E67F', '#E3DE8C', '#D8A076', '#D83762', '#76B6D8', 'REMOVE',
                        '#1C7A90', '#249CB8', '#4ABED9', '#FBD75B', '#FBE571', '#FFFFFF'
                    ],
                    quickInsertTags: [],
                    toolbarButtons: ['emoticons'],
                    paragraphFormatSelection: true,
                    refreshAfterCallback: true,
                    htmlUntouched: true,
                    htmlAllowedTags: ['.*', 'jargon'],
                    htmlRemoveTags: ['']

                                }" v-model="jotComment"></froala>
                            </div>
                        </b-col>
                    </b-row>
                </form>
            </div>

            <template v-slot:modal-footer>
                <b-button size="md" @click="addComment()" variant="success">
                    <i class="fas fa-plus "></i> save
                </b-button>
            </template>
        </b-modal>

        <div v-if="jot">
            {{jot.title}}
                <div class="content-class">
                    {{jot.user.name}}:
                    <v-runtime-template :template="'<div>' + jot.content_html + '</div>'"/>
                </div>

            <div v-for="(response, index) in jot.jot_responses" class="content-class">
                {{response.user.name}}:
                <v-runtime-template :template="'<div>' + response.content_html + '</div>'"/>
            </div>
        </div>
    </div>
</template>

<style>


</style>

<script>


    import axios from "axios";
    import VRuntimeTemplate from "v-runtime-template";

    export default {
        name: 'userJots',
        data() {
            return {
                jot: null,
                jotComment: null,
                config: {
                    colorsStep: 6,
                    colorsText: [
                        '#15E67F', '#E3DE8C', '#D8A076', '#D83762', '#76B6D8', 'REMOVE',
                        '#1C7A90', '#249CB8', '#4ABED9', '#FBD75B', '#FBE571', '#FFFFFF'
                    ],
                    quickInsertTags: [],
                    toolbarButtons: ['emoticons'],
                    paragraphFormatSelection: true,
                    refreshAfterCallback: true,
                    htmlUntouched: true,
                    htmlAllowedTags: ['.*', 'jargon'],
                    htmlRemoveTags: ['']
                }
            }
        },
        components: {
            VRuntimeTemplate,
        },
        methods: {
            comment() {
                this.$bvModal.show("userJot");

            },
            addComment() {
                if (this.jotComment) {
                    let postData = {
                        comment: this.jotComment
                    }
                    axios.post('jots/' + this.jot.id, postData).then(response => {

                        this.jot = response.data.data;
                        this.jotComment = null;
                        console.log(this.jot);
                        this.$bvModal.hide("userJot");

                    }).catch(err => {
                        console.log(err);
                    });
                }

            }
        },
        created() {
            const request = axios.get("jots/" + this.$route.params.id).then(response => {
                this.jot = response.data.data;
                console.log(this.jot)
            })
        }
    }

</script>

<style lang="scss">
    .content-class {
        div {
            display: inline-block;
        }
    }
</style>
