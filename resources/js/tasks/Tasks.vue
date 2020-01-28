<template>
    <div>
        <div v-if="loading">loading..</div>
        <div v-else>
            <div class="row mb-4" v-for="row in rows" :key="row">
                <div class="col d-flex align-items-stretch" v-for="(task, column) in tasksInRow(row)"
                     :key="'row' + row + column">
                    <task-list-item
                            v-bind="task"
                    ></task-list-item>
                </div>
                <div class="col" v-for="p in placeholderInRow(row)" :key="'placeholder' + row + p"></div>
            </div>
        </div>

    </div>
</template>

<script>

    import TaskListItem from './TaskListItem';
    import axios from 'axios';

    export default {
        components: {
            TaskListItem
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