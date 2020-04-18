<template>
    <div v-if="sub_task" >
        <!--        <div v-for="(slide, i) in subTasks">-->
        <!--            <span>{{slide.title}}</span>-->
        <!--        </div>-->
        {{sub_task.title}}

        <div class="sub-task-container">

            <v-runtime-template :template="'<div>' + sub_task.content + '</div>'"/>

<!--            <img v-if="sub_task.media_type === 'image'" v-bind:src="sub_task.imageUrl" height="100" width="100">-->

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
        created(){
            console.log('yo');
            console.log(this.sub_task);
        },
        mounted: function() {
            console.log(this.sub_task.imageUrl);
            // this.$refs.videoRef.src = this.sub_task.imageUrl;
            // this.$refs.videoRef.play();
        }

    }
</script>

<style>

    .sub-task-container{
        display: flex;
        flex-direction: row;
    }


</style>