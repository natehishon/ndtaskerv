<template>

    <div class="jot-page">

        <b-modal
            id="userJot" size="xl"
            title="add comment"
        >
            <div class="container-fluid">
                <form enctype="multipart/form-data" class="way-form">
                    <b-row>

                        <b-col xs="10">
                            <div class="form-group">
                                <froala :tag="'textarea'"
                                        :key="'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2=='"
                                        :attribution="false" :config="{

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

        <div v-if="jot" class="jot-top-container">

            <!--                <div class="jotable-container" v-if="jot.jotable">-->

            <!--                        <div class="question-container">-->
            <!--                            <span>jot question topic:</span><br>-->
            <!--                            <span style="font-weight: 900">{{jot.jotable.title}}</span><br>-->
            <!--                            <div class="jot-content-container"> <v-runtime-template style="display:inline-block" :template="'<div>' + jot.jotable.content_html + '</div>'"/></div>-->
            <!--                        </div>-->

            <!--                        <div class="image-container">-->
            <!--                            <b-img v-if="jot.jotable.image_url" v-bind:src="jot.jotable.image_url" fluid-->
            <!--                                   style="cursor: pointer; margin: 0 40px; max-width: 150px;"></b-img>-->
            <!--                        </div>-->

            <!--                </div>-->

            <div class="stat-container">

                <b-card style="min-width: 350px">
                    <template v-slot:header>
                        <h5 class="mb-0">inital jot asked by {{jot.user.name}}</h5>
                    </template>
                    <b-card-title>{{jot.title}}</b-card-title>
                    <b-card-text><v-runtime-template style="display:inline-block" :template="'<div>' + jot.content_html + '</div>'"/></b-card-text>
                </b-card>

                <div class="follow-up-container">
                    <div class="comment-button-container">
                        <span>jot question follow up:</span>
                    </div>
                    <b-button size="lg" @click="comment()" class="mb-4 mt-2 large-button" variant="success">
                        <i class="fas fa-plus "></i> comment
                    </b-button>
                    <div v-for="(response, index) in jot.jot_responses" class="content-class"
                         v-bind:class="{ 'manager-chat':response.user_id != jot.user_id }">

                        <div class="jot-convo speech-bubble"
                             v-bind:class="{ 'user-response sb6': response.user_id == jot.user_id, 'manager-response sb5':response.user_id != jot.user_id }">
                            {{response.user.name}}:
                            <v-runtime-template :template="'<div>' + response.content_html + '</div>'"/>
                        </div>

                    </div>
                </div>
            </div>

            <div class="jot-convo-container">


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
    .jot-page {
        font-size: 1.25rem;
        font-weight: 600;

        .jot-top-container {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: center;
            margin-bottom: 30px;
        }

        .jotable-container {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: center;

        }

        .jot-convo-container {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: center;

            .jot-stats {
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                justify-content: center;
            }
        }


    }

    .content-class {
        display: flex;
        div {
            display: inline-block;
        }
    }

    .manager-chat{
        justify-content: flex-end;
    }

    .user-response {
        border: 4px solid #3490dc;
    }

    .manager-response {
        border: 4px solid #38c172;
    }

    .jot-convo {
        width: 300px;
        /*margin: 5px auto;*/
        margin-bottom: 10px;
        padding: 5px;
        text-align: left;
        font-weight: 900;
        position: relative;

        p {
            margin: 0;
        }
    }

    .sb5:before {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border-left: 10px solid #38c172;
        border-right: 10px solid transparent;
        border-top: 10px solid #38c172;
        border-bottom: 10px solid transparent;
        right: -20px;
        top: 6px;
    }

    .sb5:after {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border-left: 7px solid #fff;
        border-right: 7px solid transparent;
        border-top: 7px solid #fff;
        border-bottom: 7px solid transparent;
        right: -11px;
        top: 10px;
    }

    .sb6:before {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border-left: 10px solid transparent;
        border-right: 10px solid #3490dc;
        border-top: 10px solid #3490dc;
        border-bottom: 10px solid transparent;
        left: -21px;
        top: 6px;
    }

    .sb6:after {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border-left: 7px solid transparent;
        border-right: 7px solid #fff;
        border-top: 7px solid #fff;
        border-bottom: 7px solid transparent;
        left: -11px;
        top: 10px;
    }

    .jot-content-container {
        /*max-width: 200px;*/
        display: flex;
        flex-wrap: nowrap;
        flex-direction: row;
    }

    .comment-button-container{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-top: 20px;
    }

</style>
