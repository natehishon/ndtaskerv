<template>
    <nav class="navbar bg-white border-bottom navbar-light">
        <template v-if="authenticated">

            <span class="nav-brand mr-auto">{{user.name}}</span>
            <a class="btn nav-button" @click="signOut">sign out</a>
        </template>
        <template v-else>
            <router-link class="nav-brand mr-auto" :to="{name: 'signin'}">sign In</router-link>

        </template>
    </nav>
</template>


<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user'
            })
        },
        methods: {
            ...mapActions({
                signOutAction: 'auth/signOut'
            }),

            signOut() {
                this.signOutAction().then(() => {
                    this.$router.replace({
                        name: 'signin'
                    })
                })
            }
        }
    }

</script>