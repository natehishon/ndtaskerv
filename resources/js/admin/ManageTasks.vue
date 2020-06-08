<template>

    <b-row>

        <b-col cols="12">

        <b-button size="lg" @click="newTask()" class="mb-3" variant="success">
            <i class="fas fa-plus "></i> new task
        </b-button>
        <b-table striped hover :items="tasks" :fields="fields">
            <template v-slot:cell(actions)="data">
                <b-button size="sm" @click="editTask(data.item.id)" class="mr-1">
                    edit
                </b-button>
            </template>

            <template v-slot:cell(content)="data">
                <v-runtime-template :template="'<div>' + data.item.content + '</div>'"/>
            </template>
        </b-table>
        </b-col>
    </b-row>

</template>

<style>


</style>

<script>


    import axios from "axios";
    import VRuntimeTemplate from "v-runtime-template";

    export default {
        name: 'tasks',
        data() {
            return {
                tasks: null,
                fields: ['id', 'title', 'content', 'created_at', 'actions'],
            }
        },
        components: {
            VRuntimeTemplate,
        },
        methods: {
            newTask() {
                this.$router.push({name: 'newTask'})
            },
            editTask(taskId) {
                this.$router.push({name: 'editTask', params: {id: taskId}})
            }
        },
        mounted() {
            const request = axios.get("tasks").then(response => {
                this.tasks = response.data.data;
                // this.loading = false;
            })
        }
    }

</script>
