<template>

    <b-row>

        <b-col cols="12">

<!--            <b-button size="lg" @click="newTask()" class="mb-3" variant="success">-->
<!--                <i class="fas fa-plus "></i> new task-->
<!--            </b-button>-->
            <b-table striped hover :items="jots" :fields="fields">
                <template v-slot:cell(actions)="data">
                    <b-button size="sm" >
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
        name: 'jots',
        data() {
            return {
                jots: null,
                fields: ['id', 'title', "model_type", 'created_at', 'actions'],
            }
        },
        components: {
            VRuntimeTemplate,
        },
        methods: {

        },
        mounted() {
            const request = axios.get("jots").then(response => {
                this.jots = response.data;
                // this.loading = false;
            })
        }
    }

</script>
