<template>

    <div class="">
        <b-table striped hover :items="users" :fields="fields">
            <template v-slot:cell(actions)="data">
                <b-button size="sm" @click="editUser(data.item.id)" class="mr-1">
                    edit user
                </b-button>
                <b-button size="sm" @click="manageFolders(data.item.id)" class="mr-1">
                    user folders
                </b-button>
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
                fields: ['id', 'name', 'email', 'actions'],
            }
        },
        components: {},
        methods: {
            editUser(userId) {
                console.log(userId);
            },
            manageFolders(userId){
                this.$router.push({ name: 'userFolders', params: { id: userId } })
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
