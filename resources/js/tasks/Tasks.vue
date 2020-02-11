<template>
    <div class="m-3 tasks">
        <div v-if="loading">loading..</div>
        <div v-else>
            <div class="row mr-3 ml-3 mb-3">
                <h2>wayfinder board</h2>
            </div>
            <div class="row mt-4 mb-4" v-for="row in rows" :key="row">
                <div class="col d-flex align-items-stretch" v-for="(task, column) in tasksInRow(row)"
                     :key="'row' + row + column" @click="$bvModal.show(task.id)">
                    <task-list-item class="task-list-item"
                            v-bind="task"
                    ></task-list-item>
                    <b-modal v-bind:id="task.id" size="xl" hide-footer>
                    <Task :task="task"></Task>
                    </b-modal>
                </div>
                <div class="col" v-for="p in placeholderInRow(row)" :key="'placeholder' + row + p"></div>
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
                columns: 3
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


    .task-list-item:hover{
        cursor: move;
    }

</style>