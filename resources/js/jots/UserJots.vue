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
                <!--                <form enctype="multipart/form-data">-->
                <!--                    <div class="row">-->
                <!--                        <div class="col-xs-12">-->
                <!--                            <div class="form-group">-->
                <!--                                <label for="title">Title</label>-->
                <!--                                <input type="text" class="form-control"-->
                <!--                                       v-model="newFolder.title">-->
                <!--                            </div>-->

                <!--                            <div class="form-group">-->
                <!--                                <label>folder image</label>-->
                <!--                                <input type="file" ref="file" @change="selectFolderFiles"/>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </form>-->
            </div>

            <template v-slot:modal-footer>
                <b-button size="md" @click="addComment()" variant="success">
                    <i class="fas fa-plus "></i> save
                </b-button>
            </template>
        </b-modal>

        <div v-if="jot">
            <div>
                <div class="content-class">
                    {{jot.user.name}}:
                    <v-runtime-template :template="'<div>' + jot.content + '</div>'"/>
                </div>
            </div>

            <div v-for="(response, index) in jot.jot_responses">
                <v-runtime-template :template="'<div>' + response.content + '</div>'"/>
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
                jot: null
            }
        },
        components: {
            VRuntimeTemplate,
        },
        methods: {
            comment() {
                this.$bvModal.show("userJot");

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
