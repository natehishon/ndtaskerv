<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2>{{task.title}}</h2>
                    <article>{{task.content}}</article>
                </div>
                <div class="slide-show-container">

                    <coverflow id="coverflow" :coverList="subTasks" :width="number"
                               v-on:change="onTermChange"></coverflow>
<!--                    <ul id="example-1">-->
<!--                        <li v-for="sub in subTasks">-->
<!--                            {{ sub.title }}<br>-->
<!--                            {{ sub.content }}-->
<!--                        </li>-->
<!--                    </ul>-->
                </div>
            </div>
        </div>
<!--        <div class="col-md-4 pb-4">-->
<!--            <Availability></Availability>-->
<!--        </div>-->

    </div>
</template>

<script>

    import Availability from "./Availability";
    import coverflow from 'vue-coverflow'

    export default {
        components: {
            Availability,
            coverflow
        },
        data() {
            //return an object
            return {
                task: null,
                subTasks: null,
                number: 500,
                window: {
                    width: 0,
                    height: 0
                },
                currentIndex: 0,
            };
        },
        created() {
            axios.get(`tasks/${this.$route.params.id}`).then(response => {
                this.task = response.data.data;
                this.subTasks = response.data.data.sub_task;
            });
        },
        methods: {
            onTermChange(index) {
                this.currentIndex = index;

            },
            increase() {
                this.number += 100
            }
        }
    }
</script>