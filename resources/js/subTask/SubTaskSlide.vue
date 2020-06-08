<template>
    <div v-if="sub_task" class="sub-task">
        <b-row>

            <b-col sm="12" md="6">
                <v-runtime-template :template="'<div>' + sub_task.content + '</div>'"/>
            </b-col>

            <b-col sm="12" md="6">

                <div class="image-container" v-if="sub_task.media_type === 'image'">
                    <b-img v-bind:src="sub_task.imageUrl" @click="openNewTab(sub_task.imageUrl)" fluid
                           style="cursor: pointer"></b-img>
                </div>

                <div class="video-container" v-if="sub_task.media_type === 'video'">
                    <vue-plyr>
                        <video poster="" src="video.mp4">
                            <source v-bind:src="sub_task.imageUrl" type="video/mp4" size="1080">
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
            console.log(this.sub_task.imageUrl);
            // this.$refs.videoRef.src = this.sub_task.imageUrl;
            // this.$refs.videoRef.play();
        },
        methods: {
            openMedia(crumb) {
                console.log("yo");
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
