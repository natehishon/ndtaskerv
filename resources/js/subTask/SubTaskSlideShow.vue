<template>
    <div>
        <sub-task-slide v-bind:sub-task="subTasks[currentIndex]"></sub-task-slide>


        <b-button v-on:click="previousSlide()">previous</b-button>
        <b-button v-on:click="nextSlide()">next</b-button>

        <div v-for="(item, index) in subTasks" v-on:click="goToSlide(index)">
            {{index}}
        </div>

    </div>
</template>

<script>
    import SubTaskSlide from './SubTaskSlide'
    export default {
        components: {
            SubTaskSlide,
        },
        props: ['subTasks'],
        data() {
            //return an object
            return {
                currentIndex: 0
            }
        },
        methods: {
            nextSlide() {
                if(this.currentIndex < this.subTasks.length - 1){
                    this.currentIndex++;
                }
            },
            previousSlide() {
                if(this.currentIndex > 0){
                    this.currentIndex--;
                }
            },
            goToSlide(choice){
                this.currentIndex = choice;
            }
        }
    };
</script>

<style>


</style>