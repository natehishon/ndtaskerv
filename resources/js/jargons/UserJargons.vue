<template>

    <b-row>

        <b-col cols="12">
            <b-table hover :items="jargons" :fields="fields" :sort-by.sync="sortBy">

                <template v-slot:cell(content_html)="data">
                    <v-runtime-template :template="'<div>' + data.item.content_html + '</div>'"/>
                </template>

                <template v-slot:cell(actions)="data">
                    <b-dropdown no-caret variant="white" class="manage-dropdown">
                        <template v-slot:button-content>
                            <span style="font-size: 14px">options</span>&nbsp;&nbsp;<i class="fas fa-ellipsis-h"
                                                                                       style="font-size: 14px;"></i>
                        </template>
                        <b-dropdown-item @click="checkJargon(data.item.id)">check jargon&nbsp;&nbsp;<i
                            class="fas fa-search"></i>
                        </b-dropdown-item>
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
        name: 'userJargons',
        data() {
            return {
                sortBy: 'formattedDate',
                jargons: null,
                // fields: ['title', 'formattedDate', 'actions'],
                fields: [
                    {
                        title: {
                            label: 'title',
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
            checkJargon(jargonId){
                this.$router.push({name: 'jargonPage', params: {id: jargonId}})
            }
        },
        mounted() {
            const request = axios.get("jargons").then(response => {
                this.jargons = response.data.data;
                // this.loading = false;
            })
        }
    }

</script>
