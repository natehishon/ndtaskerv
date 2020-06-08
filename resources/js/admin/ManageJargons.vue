<template>

    <div class="">
        <b-button size="sm" @click="newJargon()" class="mr-1">
            new jargon
        </b-button>
        <b-table striped hover :items="jargons" :fields="fields">

            <template v-slot:cell(content)="data">
                <v-runtime-template :template="'<div>' + data.item.content + '</div>'"/>
            </template>

            <template v-slot:cell(actions)="data">
                <b-button size="sm" @click="editJargon(data.item.id)" class="mr-1">
                    edit
                </b-button>
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
                fields: ['id', 'title', 'content', 'created_at', 'actions'],
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
