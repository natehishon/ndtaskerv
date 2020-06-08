<template>

    <div class="index">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
        <Nav :routeName="currentRouteName" @created="handleCreate"></Nav>

        <div class="vertical-spacer"></div>

        <b-container fluid v-if="authenticated">
            <router-view :key="$route.fullPath"></router-view>
        </b-container>

        <b-container fluid v-if="!authenticated">
            <b-row>
                <b-col cols="12">
                    <router-view :key="$route.fullPath"></router-view>
                </b-col>
            </b-row>
        </b-container>


    </div>

</template>


<script>

    import Nav from './Nav';
    import VAButton from 'vue2-admin-lte/src/components/VAButton.vue'
    import Sidebar from './Sidebar';
    import {mapGetters} from 'vuex';

    export default {

        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user'
            }),
            currentRouteName() {
                return this.$route.name;
            }

        },



        components: {
            Nav,
            Sidebar,
            'va-button': VAButton,
        },
        data() {
            return {
                route: 0
            }
        },

        methods: {
            handleCreate() {
                console.log('Child has been created.');
                this.route += 1;
            }
        }
    }

</script>

<style lang="scss">
    .vertical-spacer{
        height: 40px;
    }

</style>
