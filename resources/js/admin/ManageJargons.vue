<template>

    <div class="">
        <b-button size="lg" @click="newJargon()" class="mb-3" variant="success">
            new jargon&nbsp;&nbsp;<i class="fas fa-plus "></i>
        </b-button>
        <b-table hover :items="jargons" :fields="fields">

            <template v-slot:cell(content_html)="data">
                <v-runtime-template :template="'<div>' + data.item.content_html + '</div>'"/>
            </template>

            <template v-slot:cell(actions)="data">
                <b-dropdown no-caret variant="white" class="manage-dropdown">
                    <template v-slot:button-content>
                        <span style="font-size: 14px">options</span>&nbsp;&nbsp;<i class="fas fa-ellipsis-h"
                                                                                   style="font-size: 14px;"></i>
                    </template>
                    <b-dropdown-item @click="editJargon(data.item.id)">edit jargon&nbsp;&nbsp;<i class="fas fa-edit"></i>
                    </b-dropdown-item>
                    <b-dropdown-item @click="deleteJargon(data.item.id)">delete jargon&nbsp;&nbsp;<i
                        class="fas fa-trash"></i></b-dropdown-item>
                </b-dropdown>

            </template>
        </b-table>
    </div>
</template>

<style>


</style>

<script>

    import axios from "axios";
    import VRuntimeTemplate from "v-runtime-template";

    export default {
        name: 'manageJargons',
        data() {
            return {
                jargons: null,
                fields: [
                    {
                        title: {
                            label: 'title'
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
            newJargon() {
                this.$router.push({name: 'newJargon'})
            },
            editJargon(jargonId) {
                this.$router.push({name: 'editJargon', params: {id: jargonId}})
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
