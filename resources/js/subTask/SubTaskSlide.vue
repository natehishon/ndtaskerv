<template>
    <div v-if="sub_task">
        <!--        <div v-for="(slide, i) in subTasks">-->
        <!--            <span>{{slide.title}}</span>-->
        <!--        </div>-->
        <span class="subtask-title mt-3 mb-3">{{sub_task.title}}</span>

        <div class="sub-task-container">

            <v-runtime-template :template="'<div>' + sub_task.content + '</div>'"/>

            <div class="img-container">
                <img class="sub-task-img" @click="openMedia()" v-if="sub_task.media_type === 'image'"
                     v-bind:src="sub_task.imageUrl">
            </div>
            <!--            <video v-if="sub_task.media_type === 'video'" ref="videoRef" src="" id="video-container" width="100%" controls></video>-->

        </div>

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
            }
        }

    }
</script>

<style>

    .sub-task-container {
        display: flex;
        flex-direction: row;
    }

    .subtask-title {
        font-weight: 700;
    }

    .img-container{
        width: 200px;
        margin: 0 5px;

    }
    .sub-task-img {
        width: 100%;
    }


</style>