<template>

    <div class="">

        <b-button size="lg" @click="newTask()" class="mb-3" variant="success">
            new user&nbsp;&nbsp;<i class="fas fa-plus"></i>
        </b-button>

        <b-table hover :items="users" :fields="fields">
            <template v-slot:cell(actions)="data">

                <b-dropdown no-caret variant="white" class="manage-dropdown">
                    <template v-slot:button-content>
                        <span style="font-size: 14px">options</span>&nbsp;&nbsp;<i class="fas fa-ellipsis-h"
                                                                                   style="font-size: 14px;"></i>
                    </template>
                    <b-dropdown-item @click="editUser(data.item.id)">edit user&nbsp;&nbsp;<i class="fas fa-edit"></i>
                    </b-dropdown-item>
                    <b-dropdown-item @click="manageFolders(data.item.id)">user folders&nbsp;&nbsp;<i
                        class="far fa-folder"></i></b-dropdown-item>
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
        name: 'users',
        data() {
            return {
                users: null,
                fields: [
                    {
                        name: {
                            label: 'user name'
                        },
                    },
                    {
                        email: {
                            label: 'user email'
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
        components: {},
        methods: {
            editUser(userId) {
                console.log(userId);
            },
            manageFolders(userId) {
                this.$router.push({name: 'userFolders', params: {id: userId}})
            }
        },
        mounted() {
            const request = axios.get("users").then(response => {
                this.users = response.data.data;
                // this.loading = false;
            })
        }
    }

</script>
