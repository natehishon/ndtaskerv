<template>
    <div>
        <sub-task-slide v-if="sub_tasks" v-bind:sub_task="sub_tasks[currentIndex]"></sub-task-slide>


        <b-button v-on:click="previousSlide()">previous</b-button>
        <b-button v-on:click="nextSlide()">next</b-button>

        <div v-for="(item, index) in sub_tasks" v-on:click="goToSlide(index)">
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
        props: ['sub_tasks'],
        data() {
            //return an object
            return {
                currentIndex: 0
            }
        },
        methods: {
            nextSlide() {
                if(this.currentIndex < this.sub_tasks.length - 1){
                    this.currentIndex++;
                    this.$emit('slide-change', this.currentIndex)
                }
            },
            previousSlide() {
                if(this.currentIndex > 0){
                    this.currentIndex--;
                    this.$emit('slide-change', this.currentIndex)
                }
            },
            goToSlide(choice){
                this.currentIndex = choice;
                this.$emit('slide-change', this.currentIndex)
            }
        }
    };
</script>

<style>


</style>