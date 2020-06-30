<template>

    <b-row>

        <b-col cols="12">

            <!--            <b-button size="lg" @click="newTask()" class="mb-3" variant="success">-->
            <!--                <i class="fas fa-plus "></i> new task-->
            <!--            </b-button>-->
            <b-table hover :items="jots" :fields="fields">

                <template v-slot:cell(content)="data">
                    <v-runtime-template :template="'<div>' + data.item.content_html + '</div>'"/>
                </template>

                <template v-slot:cell(jotable_type)="data">
                    <span>{{getJotType(data.value)}}</span>
                </template>

                <template v-slot:cell(actions)="data">
                    <b-dropdown no-caret variant="white" class="manage-dropdown">
                        <template v-slot:button-content>
                            <span style="font-size: 14px">options</span>&nbsp;&nbsp;<i class="fas fa-ellipsis-h"
                                                                                       style="font-size: 14px;"></i>
                        </template>
                        <b-dropdown-item @click="checkJot(data.item.id)">check jot&nbsp;&nbsp;<i
                            class="fas fa-comment"></i>
                        </b-dropdown-item>
                        <b-dropdown-item @click="editJot(data.item.id)">delete jot&nbsp;&nbsp;<i
                            class="fas fa-trash"></i></b-dropdown-item>
                    </b-dropdown>
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
        name: 'manageJots',
        data() {
            return {
                jots: null,
                // fields: ['user', 'title', "Jot Type", 'created_at', 'actions'],
                fields: [
                    {
                        user: {
                            label: 'user name'
                        },
                    },
                    {
                        title: {
                            label: 'jot title'
                        },
                    },
                    {
                        jotable_type: {
                            label: 'jot type'
                        },
                    },
                    {
                        formattedDate: {
                            label: 'created date'
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
            checkJot(jotId) {
                this.$router.push({name: 'userJots', params: {id: jotId}})
            },
            getJotType(data) {
                if (data === "App\\SubTask") {
                    return 'task step';
                }
                if (data === "App\\Task") {
                    return 'task';
                }
            }
        },
        mounted() {
            const request = axios.get("jots-admin").then(response => {
                this.jots = response.data;
                // this.loading = false;
            })
        }
    }

</script>
