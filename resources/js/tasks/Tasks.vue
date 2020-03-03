<template>
    <div class="tasks">
        <div v-if="loading">loading..</div>
        <div v-else>

            <b-row >
                <b-col cols="12">
                    <h2>wayfinder board</h2>
                </b-col>
            </b-row>

            <div class="task-type-container">
                <div class="type-column" v-for="sort in sorters">

                    <span>{{sort.title}}</span>
<!--                    <div >-->
<!--                        <h2>{{sort.title}}</h2>-->
<!--                    </div>-->


                </div>
            </div>

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

<style lang="scss">

    .tasks{
        margin: 1rem 0;
    }

    .task-list-item:hover{
        cursor: move;
    }

    .task-type-container{
        margin-top: 30px;
        /*max-width: 90%;*/
        /*margin: 0 auto;*/
        display: -webkit-box;
        flex-direction: row;
        flex-wrap: nowrap;
        /*justify-content: space-evenly;*/
        overflow-x: scroll;
        -webkit-overflow-scrolling: touch;
        scroll-snap-type: x mandatory;


        .type-column{
            background-color: blue;
            width: 200px;
            /*width: 20%;*/
            /*flex-grow: 1;*/
            margin: 0 5px;
            scroll-snap-align: start;
        }
    }



    @media only screen and (min-width: 720px) {
        .task-type-container{

            display: flex;

            .type-column{
                background-color: red;
            }
        }
    }


</style>