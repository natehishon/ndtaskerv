<template>
    <div class="tasks">
        <div v-if="loading">loading..</div>
        <div v-else>

            <b-row >
                <b-col cols="12">
                    <h2>wayfinder board</h2>
                </b-col>
            </b-row>

            <b-row class="task-type-container">
                <b-col cols="3" class="" v-for="sort in sorters">

                    <span>{{sort.title}}</span>
<!--                    <div >-->
<!--                        <h2>{{sort.title}}</h2>-->
<!--                    </div>-->


                </b-col>
            </b-row>

<!--                <div class="col d-flex align-items-stretch" v-for="(task, column) in tasksInRow(row)"-->
<!--                     :key="'row' + row + column" @click="$bvModal.show(task.id)">-->
<!--                    <task-list-item class="task-list-item"-->
<!--                            v-bind="task" :task="task"-->
<!--                    ></task-list-item>-->
<!--                    <b-modal v-bind:id="task.id" size="xl" hide-footer>-->
<!--                    <Task :task="task"></Task>-->
<!--                    </b-modal>-->
<!--                </div>-->
<!--                <div class="col" v-for="p in placeholderInRow(row)" :key="'placeholder' + row + p"></div>-->
            </div>
        </div>

    </div>
</template>

<script>

    import TaskListItem from './TaskListItem';
    import Task from '../task/Task'
    import axios from 'axios';

    export default {
        components: {
            TaskListItem,
            Task
        },
        data() {
            return {
                tasks: null,
                loading: null,
                columns: 3,
                sorters: [
                    {
                        title: "today's things",
                        value: "today"
                    },
                    {
                        title: "future things to look at",
                        value: "future"
                    },
                    {
                        title: "completed things ",
                        value: "past"
                    },
                    {
                        title: "other things ",
                        value: "other"
                    },
                ]
            }
        },
        computed: {
            rows() {
                return this.tasks == null ? 0 : Math.ceil(this.tasks.length / this.columns)
            }
        },
        methods: {
            tasksInRow(row) {
                return this.tasks.slice((row - 1) * this.columns, row * this.columns)
            },
            placeholderInRow(row) {
                return this.columns - this.tasksInRow(row).length;
            }
        },
        created() {
            this.loading = true;

            const request = axios.get("tasks").then(response => {
                this.tasks = response.data.data;
                console.log(this.tasks);
                this.loading = false;
            })
        }
    };

</script>

<style>

    .tasks{
        margin: 1rem 0;
    }

    .task-list-item:hover{
        cursor: move;
    }

    .task-type-container{
        max-width: 80%;
        margin: 0 auto;
        display: flex;
        /*flex*/
    }

</style>