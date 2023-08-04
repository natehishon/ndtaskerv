<template>

    <div class="">

        <b-button size="lg" @click="newTask()" class="mb-3" variant="success">
            <i class="fas fa-plus"></i>&nbsp;new user
        </b-button>

        <b-table hover :items="users" :fields="fields">
            <template v-slot:cell(actions)="data">

                <b-dropdown no-caret variant="white" class="manage-dropdown">
                    <template v-slot:button-content>
                        <i class="fas fa-ellipsis-h" style="font-size: 14px;"></i>
                        &nbsp;<span style="font-size: 14px">options</span>
                    </template>
                    <b-dropdown-item @click="editUser(data.item.id)">
                        <i class="fas fa-edit"></i>&nbsp;edit user
                    </b-dropdown-item>
                    <b-dropdown-item @click="manageFolders(data.item.id)">
                        <i class="far fa-folder"></i>&nbsp;user folders
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
                //test
                // this.loading = false;
            })
        }
    }

</script>
