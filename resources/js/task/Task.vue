<template>


    <div class="task-container">

        <b-row>
            <b-col sm="12">
                <b-tabs pills card vertical fill class="tabs-yo">

                    <b-tab v-for="subTask in task.sub_task" :title="subTask.title" :key="subTask.id">
                        <sub-task-slide class="sub-slide" v-if="subTask"
                                        v-bind:sub_task="subTask"></sub-task-slide>
                    </b-tab>
                    <!--                    <b-tab title="Tab 1" active>-->
                    <!--                        <b-col sm="12" md="6">-->
                    <!--                            <v-runtime-template :template="'<div>' + task.content + '</div>'"/>-->
                    <!--                        </b-col>-->

                    <!--                        <b-col sm="12" md="6">-->

                    <!--                            <div class="image-container" v-if="task.media_type === 'image'">-->
                    <!--                                <b-img v-bind:src="task.imageUrl" fluid></b-img>-->
                    <!--                            </div>-->

                    <!--                            <div class="video-container" v-if="task.media_type === 'video'">-->
                    <!--                                <vue-plyr>-->
                    <!--                                    <video poster="" src="video.mp4">-->
                    <!--                                        <source v-bind:src="task.imageUrl" type="video/mp4" size="1080">-->
                    <!--                                    </video>-->
                    <!--                                </vue-plyr>-->
                    <!--                            </div>-->


                    <!--                        </b-col>-->
                    <!--                    </b-tab>-->
                    <!--                    <b-tab title="Tab 2">-->
                    <!--                        yoo-->
                    <!--                    </b-tab>-->
                    <!--                    <b-tab title="Tab 3">-->
                    <!--                        what up-->
                    <!--                    </b-tab>-->
                </b-tabs>
            </b-col>


        </b-row>

        <!--        <subTaskSlideShow v-on:slide-change="slideChange" v-if="task.sub_task.length > 0"-->
        <!--                          v-bind:sub_tasks="task.sub_task"></subTaskSlideShow>-->

    </div>

</template>

<script>

    import Jargon from '../jargons/Jargon';
    import SubTaskSlideShow from '../subTask/SubTaskSlideShow'
    import VRuntimeTemplate from "v-runtime-template";
    import SubTaskSlide from "../subTask/SubTaskSlide";

    export default {
        components: {
            SubTaskSlide,
            SubTaskSlideShow,
            Jargon,
            VRuntimeTemplate,

        },
        props: ['task'],
        data() {
            //return an object
            return {
                number: 500,
                window: {
                    width: 0,
                    height: 0
                },
                currentIndex: 0,

            };
        },
        mounted: function () {

        },
        created() {

        },
        methods: {
            onTermChange(index) {
                this.currentIndex = index;

            },
            increase() {
                this.number += 100
            },
            slideChange(event) {
                this.$emit('task-slide', event)
            }
        },
        computed: {
            // a computed getter
            taskTemplate: function () {
                // `this` points to the vm instance
                return '<div>' + this.task.content + '</div>'
            }
        },
    }
</script>

<style lang="scss">

    button:focus {
        outline: none !important;
    }

    .vueperslides__progress {
        background: rgba(0, 0, 0, 0.25);
        color: #D7FCF9;
    }

    .slides-container {
        /*max-width: 500px;*/
        /*min-width: 500px;*/
    }

    .vueperslides__bullet .default {
        background-color: rgba(0, 0, 0, 0.3);
        border: none;
        box-shadow: none;
        transition: 0.3s;
        width: 16px;
        height: 16px;
    }

    .vueperslides__bullet--active .default {
        background-color: #42b983;
        outline: none;
    }

    .vueperslides__bullet span {
        display: block;
        color: #fff;
        font-size: 10px;
        opacity: 0.8;
    }

    .vueperslides__arrow {
        color: gray
    }

    .icon {
        font-style: normal;
    }

    .bullet-active {
        font-weight: 900;
        color: blue;
    }

    .content-container {
        margin: 0 33px;
    }

    .video-js .vjs-control-bar {
        bottom: -30px;
    }

    .video-js .vjs-control-bar, .vjs-fade-in, .vjs-fade-out {
        visibility: visible !important;
        opacity: 1 !important;
        transition-duration: 0s !important;
        display: block !important;
    }

    .tabs-yo {

        .card-header {
            background-color: white;
        }

    }


</style>
