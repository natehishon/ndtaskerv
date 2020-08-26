<template>

    <b-row>

        <b-col cols="12">

            <b-button size="lg" @click="newTask()" class="mb-3" variant="success">
                <i class="fas fa-plus "></i>&nbsp;new task
            </b-button>
            <b-table hover :items="tasks" :fields="fields" :sort-by.sync="sortBy">
                <template v-slot:cell(actions)="data">

                    <b-dropdown no-caret variant="white" class="manage-dropdown">
                        <template v-slot:button-content>
                            <i class="fas fa-ellipsis-h" style="font-size: 14px;"></i>
                            &nbsp;<span style="font-size: 14px">options</span>
                        </template>
                        <b-dropdown-item @click="editTask(data.item.id)">
                            <i class="fas fa-edit"></i>&nbsp;edit task
                        </b-dropdown-item>
                        <b-dropdown-item @click="deleteTask(data.item.id)">
                            <i class="fas fa-trash"></i>&nbsp;delete task
                        </b-dropdown-item>
                    </b-dropdown>

                    <!--                <b-button size="sm" @click="editTask(data.item.id)" variant="white">-->
                    <!--                    options&nbsp;<i class="fas fa-ellipsis-h "></i>-->
                    <!--                </b-button>-->
                </template>

                <template v-slot:cell(content_html)="data">
                    <v-runtime-template :template="'<div>' + data.item.content_html + '</div>'"/>
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
                sortBy: 'formattedDate',
                tasks: null,
                //fields: ['id', 'title', 'content_html', 'created_at', 'actions'],
                fields: [
                    {
                        title: {
                            label: 'title',
                            sortable: true

                        },
                    },
                    {
                        content_html: {
                            label: 'content',
                            sortable: true
                        },
                    },
                    {
                        formattedDate: {
                            label: 'created date',
                            sortable: true
                        },
                    },
                    {
                        actions: {
                            label: 'actions'
                        },
                    },
                ]
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

<style lang="scss">
    .manage-dropdown {
        button {
            padding: 0 !important;
        }
    }
</style>
