<template>

    <div class="">
        <b-button size="lg" @click="newJargon()" class="mb-3" variant="success">
            <i class="fas fa-plus "></i>&nbsp;new jargons
        </b-button>
        <b-table hover :items="jargons" :fields="fields" :sort-by.sync="sortBy">

            <template v-slot:cell(content_html)="data">
                <v-runtime-template :template="'<div>' + data.item.content_html + '</div>'"/>
            </template>

            <template v-slot:cell(actions)="data">
                <b-dropdown no-caret variant="white" class="manage-dropdown">
                    <template v-slot:button-content>
                        <i class="fas fa-ellipsis-h" style="font-size: 14px;"></i>&nbsp;<span style="font-size: 14px">options</span>
                    </template>
                    <b-dropdown-item @click="editJargon(data.item.id)">
                        <i class="fas fa-edit"></i>&nbsp;edit jargon
                    </b-dropdown-item>
                    <b-dropdown-item @click="deleteJargon(data.item.id)">
                        <i class="fas fa-trash"></i>&nbsp;delete jargon&nbsp;&nbsp;
                    </b-dropdown-item>
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
                sortBy: 'formattedDate',
                jargons: null,
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
