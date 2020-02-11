<template>


    <div v-if="authenticated" class="side-bar">


        <div class="mt-3">

            <div class="side-bar-title">
                <span >things</span>
            </div>

            <b-nav vertical class="bd-sidenav">
                <b-nav-item>
                    <router-link class="router-link" :to="{name: 'home'}">profile</router-link>
                </b-nav-item>
                <b-nav-item>
                    <router-link class="router-link" :to="{name: 'home'}">tasks</router-link>
                </b-nav-item>
                <b-nav-item>
                    <router-link class="router-link" :to="{name: 'home'}">my tasks</router-link>
                </b-nav-item>

            </b-nav>
        </div>


        <div v-if="user.isAdmin">

            <div class="side-bar-title">
                <span >admin things</span>
            </div>

            <b-nav vertical class="">
                <b-nav-item>
                    <router-link class="router-link" :to="{name: 'newTask'}">New Task</router-link>
                </b-nav-item>
<!--                <b-nav-item>-->
<!--                    <router-link :to="{name: 'home'}">Tasks</router-link>-->
<!--                </b-nav-item>-->
                <!--                <b-nav-item>Link</b-nav-item>-->
                <!--                <b-nav-item>Another Link</b-nav-item>-->
                <!--                <b-nav-item disabled>Disabled</b-nav-item>-->
            </b-nav>

<!--            <ul class="side-bar-menu">-->


<!--                <li v-for="link in adminSideBarLinks">-->
<!--                    <i v-bind:class="link.icon"></i>-->
<!--                    <router-link class="nav-brand mr-auto router-link" :to="{name: link.route}">{{link.title}}-->
<!--                    </router-link>-->
<!--                </li>-->

<!--            </ul>-->

        </div>
    </div>

</template>


<script>

    import { mapGetters } from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user'
            })
        },
        data() {
            //return an object
            return {
                sideBarLinks: [
                    {
                        title: 'Profile',
                        route: 'home',
                        icon: 'fa fa-fw fa-microchip'
                    },
                    {
                        title: 'Tasks',
                        route: 'home',
                        icon: ''
                    },
                    {
                        title: 'My Tasks',
                        route: 'mytasks',
                        icon: ''
                    },
                ],
                adminSideBarLinks: [
                    {
                        title: 'New Task',
                        route: 'newTask',
                        icon: 'fa fa-fw fa-microchip'
                    },
                ]
            }
        }
    };

</script>

<style>

    .side-bar{
        /*border-right: 1px solid rgba(0,0,0,.1);*/
        height: 100%
    }

    .side-bar-title{
        text-align: left;
        width: 100%;
        margin: 10px 0 0;
        font-weight: 900;
        font-size: 16px;
        padding: .25rem 0.5rem;
    }

    .nav-link{
        padding: .25rem 0.5rem;
    }

    .router-link {
        display: block;
        /*padding: .25rem 1.5rem;*/
        font-size: 90%;
        color: rgba(0, 0, 0, .65);
    }

    .router-link:hover{
        text-decoration: none;
        font-weight: 900;
        color: black;
    }



</style>