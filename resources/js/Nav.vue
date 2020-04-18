<template>
    <div>
        <b-navbar toggleable="lg" variant="light" >
            <b-navbar-brand href="/">wayfinder</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav v-if="authenticated">

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto" >
                    <b-nav-form class="ml-2" @submit.stop.prevent="searchSubmit()">
                        <b-form-input v-model="search" class="mr-sm-2" placeholder="search"></b-form-input>
                        <b-button variant="outline-dark" class="my-2 my-sm-0" type="submit">Search</b-button>
                    </b-nav-form>
<!--                    <b-nav-item href="/">home</b-nav-item>-->
<!--                    <b-nav-item href="#">jargons</b-nav-item>-->
<!--                    <b-nav-form>-->
<!--                        <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>-->
<!--                        <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>-->
<!--                    </b-nav-form>-->

<!--                    <b-nav-item-dropdown text="Lang" right>-->
<!--                        <b-dropdown-item href="#">EN</b-dropdown-item>-->
<!--                        <b-dropdown-item href="#">ES</b-dropdown-item>-->
<!--                        <b-dropdown-item href="#">RU</b-dropdown-item>-->
<!--                        <b-dropdown-item href="#">FA</b-dropdown-item>-->
<!--                    </b-nav-item-dropdown>-->

                    <b-nav-item-dropdown right>

                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content>
                            <span>me</span>
                        </template>
                        <b-dropdown-item :to="'profile'">edit profile</b-dropdown-item>
                        <b-dropdown-item href="#" @click="signOut">sign out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
<!--    <nav class="navbar bg-white border-bottom navbar-light">-->
<!--        <template v-if="authenticated">-->

<!--            <span class="nav-brand mr-auto">{{user.name}}</span>-->
<!--            <a class="btn nav-button" @click="signOut">sign out</a>-->
<!--        </template>-->
<!--        <template v-else>-->
<!--            <router-link class="nav-brand mr-auto" :to="{name: 'signin'}">sign In</router-link>-->

<!--        </template>-->
<!--    </nav>-->
</template>


<script>
    import axios from 'axios';
    import {mapGetters, mapActions} from 'vuex';

    export default {
        props: [ '' ],
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
            },
            searchSubmit(){
                console.log("search?");

                // this.$router.push({ path: 'register', query: { plan: 'private' } })
                let search = this.search;
                this.$router.push({ path: 'search', query: { q: this.search } }).catch((err) => {
                    this.$emit('search')
                });

                this.$emit('created');

            }
        },
        data() {
            return {
                search:'',
            }
        },
        mounted(){
            this.search = this.$route.query.q;
        }
    }

</script>