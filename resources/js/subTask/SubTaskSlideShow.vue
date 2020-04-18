<template>
    <div class="subtask-parent">
        <div class="subtask-container">
            <i class="fas fa-arrow-left" v-on:click="previousSlide()"></i>
            <sub-task-slide class="sub-slide" v-if="sub_tasks"
                            v-bind:sub_task="sub_tasks[currentIndex]"></sub-task-slide>
            <i class="fas fa-arrow-right" v-on:click="nextSlide()"></i>

        </div>
        <div class="number-container">
            <div class="circle" v-bind:class="{ active: currentIndex == index }" v-for="(item, index) in sub_tasks" v-on:click="goToSlide(index)">
                <span>{{index + 1}}</span>
            </div>
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
                if (this.currentIndex < this.sub_tasks.length - 1) {
                    this.currentIndex++;
                    this.$emit('slide-change', this.currentIndex)
                }
            },
            previousSlide() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                    this.$emit('slide-change', this.currentIndex)
                }
            },
            goToSlide(choice) {
                this.currentIndex = choice;
                this.$emit('slide-change', this.currentIndex)
            }
        }
    };
</script>

<style lang="scss">

    .subtask-container {
        display: flex;
        flex-direction: row;
        align-items: center;

        .sub-slide {
            margin: 20px;
        }

        .fas {
            cursor: pointer;
        }
    }

    .number-container{
        display: flex;
        flex-direction: row;
        justify-content: center;

        .circle{
            background-color: grey;
            border-radius: 12px;
            border: none;
            width: 25px;
            height: 25px;
            text-align: center;
            margin: 0 5px;
            cursor: pointer;
            span{
                display: block;
                color: #fff;
                font-size: 15px;
                line-height: 24px;
                font-weight: 900;
            }
        }
        .circle.active{
            background-color: #00d1b2;
        }
    }

</style>