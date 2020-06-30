<template>

    <div class="">
        <b-button size="lg" @click="prebuiltFolder()" class="mb-3" variant="success">
            new prebuilt folder&nbsp;&nbsp;<i class="fas fa-plus"></i>
        </b-button>

        <b-table hover :items="prebuiltFolders" :fields="fields">
            <template v-slot:cell(actions)="data">

                <b-dropdown no-caret variant="white" class="manage-dropdown">
                    <template v-slot:button-content >
                        <span style="font-size: 14px">options</span>&nbsp;&nbsp;<i class="fas fa-ellipsis-h" style="font-size: 14px;"></i>
                    </template>
                    <b-dropdown-item>manage tasks&nbsp;&nbsp;<i class="fas fa-edit"></i></b-dropdown-item>
<!--                    <b-dropdown-item @click="manageFolders(data.item.id)">user folders&nbsp;&nbsp;<i class="far fa-folder"></i></b-dropdown-item>-->
                </b-dropdown>
            </template>
        </b-table>
    </div>
</template>

<style>


</style>

<script>

    import axios from "axios";

    export default {
        name: 'prebuiltFolders',
        data() {
            return {
                prebuiltFolders: null,
                fields: ['id', 'title', 'actions'],
            }
        },
        components: {},
        methods: {

        },
        mounted() {
            const request = axios.get("prebuilt-folders").then(response => {
                this.prebuiltFolders = response.data.folders;
                // this.loading = false;
            })
        }
    }

</script>
