<template>
    <div v-if="sub_task" class="sub-task">

        <b-row v-if="!task.image_url">
            <b-col sm="12" >
                <v-runtime-template :template="'<div>' + sub_task.content_html + '</div>'"/>
            </b-col>
        </b-row>

        <b-row v-if="task.image_url">

            <b-col sm="12" md="6">
                <v-runtime-template :template="'<div>' + sub_task.content_html + '</div>'"/>
            </b-col>

            <b-col sm="12" md="6">

                <div class="image-container" v-if="sub_task.media_type === 'image'">
                    <b-img center v-bind:src="sub_task.image_url" @click="openNewTab(sub_task.image_url)" fluid
                           style="cursor: pointer; max-height: 400px;"></b-img>
                </div>

                <div class="video-container" v-if="sub_task.media_type === 'video'">
                    <vue-plyr>
                        <video poster="" src="video.mp4">
                            <source v-bind:src="sub_task.image_url" type="video/mp4" size="1080">
                        </video>
                    </vue-plyr>
                </div>

            </b-col>
        </b-row>

    </div>
</template>

<script>

    import VRuntimeTemplate from "v-runtime-template";
    import Jargon from '../jargons/Jargon';
    import myVideo from 'vue-video'

    export default {
        components: {
            VRuntimeTemplate,
            Jargon,
            myVideo
        },
        props: ['sub_task'],
        data() {
            //return an object
            return {

                video: {
                    sources: [{
                        // src: this.sub_task.imageUrl,
                        type: 'video/mp4'
                    }],
                    options: {
                        autoplay: false,
                        // volume: 0.6,
                        // poster: 'http://covteam.u.qiniudn.com/poster.png'
                    }
                }

            }
        },
        created() {

        },
        mounted: function () {
        },
        methods: {
            openMedia(crumb) {
            },
            openNewTab(url) {
                window.open(url, "_blank");
            }
        }

    }
</script>

<style>

    .sub-task-container {
        display: flex;
        flex-direction: row;
        font-size: 18px;

    }

    .subtask-title {
        font-weight: 700;
    }

    .img-container {
        width: 200px;
        margin: 0 5px;

    }

    .sub-task-img {
        width: 100%;
    }

    .sub-task{
        font-size: 18px;
    }


</style>
