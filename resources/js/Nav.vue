<template>
    <nav class="navbar bg-white border-bottom navbar-light">
        <template v-if="authenticated">

            <span class="nav-brand">{{user.name}}</span>
            <router-link class="nav-brand mr-auto" :to="{name: 'home'}">Tasks</router-link>
            <router-link class="nav-brand mr-auto" :to="{name: 'mytasks'}">My Tasks</router-link>
            <a class="btn nav-button"  @click="signOut" >Sign Out</a>
        </template>
        <template v-else>
            <router-link class="nav-brand mr-auto" :to="{name: 'signin'}">Sign In</router-link>


        </template>
<!--                    <router-link class="btn nav-button" :to="{name: '/'}">Tasks</router-link>-->
                </nav>
</template>


<script>
    import { mapGetters, mapActions } from 'vuex';
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