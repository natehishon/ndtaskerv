<template>

    <b-row>

        <b-col cols="12">
            <b-table  hover :items="jots" :fields="fields">
                <template v-slot:cell(actions)="data">
                    <b-button size="sm" >
                        edit
                    </b-button>
                </template>

                <template v-slot:cell(jotable_type)="data">
                    <span>{{getJotType(data.value)}}</span>
                </template>

                <template v-slot:cell(content)="data">
                    <v-runtime-template :template="'<div>' + data.item.content + '</div>'"/>
                </template>

                <template v-slot:cell(actions)="data">
                    <b-dropdown no-caret variant="white" class="manage-dropdown">
                        <template v-slot:button-content>
                            <span style="font-size: 14px">options</span>&nbsp;&nbsp;<i class="fas fa-ellipsis-h"
                                                                                       style="font-size: 14px;"></i>
                        </template>
                        <b-dropdown-item @click="checkJot(data.item.id)">check jot&nbsp;&nbsp;<i class="fas fa-comments"></i>
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
        name: 'jots',
        data() {
            return {
                jots: null,
                // fields: ['id', 'title', "jotable_type", 'created_at', 'actions'],
                fields: [
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
            getJotType(data){
                if(data === "App\\SubTask"){
                    return 'task step';
                }
                if(data === "App\\Task"){
                    return 'task';
                }
            }
        },
        mounted() {
            const request = axios.get("jots").then(response => {
                this.jots = response.data;
                // this.loading = false;
            })
        }
    }

</script>
