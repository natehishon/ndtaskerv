<template>


    <div class="task-container">

        <b-row>
            <b-col sm="12">
                <b-tabs pills card vertical fill class="tabs-yo" v-model="taskIndex" nav-wrapper-class="col-sm-4 col-md-2" >

                    <div v-if="!sub[0].task">

                        <b-tab  v-for="(subTask, index) in sub" @click="tabClick(index)" :title="subTask.title" :key="subTask.id">
                            <sub-task-slide class="sub-slide" v-if="subTask"
                                            v-bind:sub_task="subTask"></sub-task-slide>
                        </b-tab>

                    </div>

                    <div v-if="sub[0].task">
                        <sub-task-slide class="sub-slide"
                                        v-bind:sub_task="task"></sub-task-slide>
                    </div>



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
        props: ['task', 'sub', 'currentIndex'],
        data() {
            //return an object
            return {
                number: 500,
                window: {
                    width: 0,
                    height: 0
                },
                taskIndex: this.currentIndex,
                currentSub: null,
                init:false

            };
        },
        mounted: function () {

        },
        created() {


            this.goToSlide()

        },
        methods: {
            tabClick(index){
                this.$emit('indexchange', index)
            },
            onTermChange(index) {
                // this.currentIndex = index;

            },
            increase() {
                this.number += 100
            },
            slideChange(event) {
                this.$emit('task-slide', event)
            },
            goToSlide(){

                if(this.$route.query.subTaskID){
                    if(this.sub.length > 0){
                        this.sub.forEach((value, index) => {
                            if(value.id == this.$route.query.subTaskID){
                                this.taskIndex = index;
                            }
                        })
                    }
                }

            }
        },
        computed: {
            // a computed getter
            taskTemplate: function () {
                // `this` points to the vm instance
                return '<div>' + this.task.content_html + '</div>'
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

    .nav-pills{
        text-align: center;
    }


</style>
