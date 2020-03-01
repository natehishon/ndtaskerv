<template>


    <div v-if="authenticated" class="side-bar">


        <div class="side-bar-parent">

            <div class="side-bar-title-container mt-3 mb-1">
                <div class="side-bar-title">
                    <span> things</span>
                </div>
            </div>

            <b-nav vertical class="bd-sidenav">
                <b-nav-item>
                    <router-link class="router-link" :to="{name: 'home'}">
                        <span style="font-size: 1em;">
                            <i class="fa fa-fw fa-user"></i>
                        </span>
                        profile
                    </router-link>
                </b-nav-item>
                <b-nav-item>
                    <router-link class="router-link" :to="{name: 'home'}">
                        <span style="font-size: 1em;">
                            <i class="fas fa-fw fa-tasks"></i>
                        </span>
                        tasks
                    </router-link>
                </b-nav-item>
                <!--                <b-nav-item>-->
                <!--                    <router-link class="router-link" :to="{name: 'home'}">my tasks</router-link>-->
                <!--                </b-nav-item>-->

            </b-nav>


            <div v-if="user.isAdmin">

                <div class="side-bar-title-container mt-2 mb-1">
                    <div class="side-bar-title">
                        <span>admin things</span>
                    </div>
                </div>

                <b-nav vertical class="">
                    <b-nav-item>
                        <router-link class="router-link" :to="{name: 'newTask'}">
                            <span style="font-size: 1em;">
                            <i class="fas fa-fw fa-sticky-note"></i>
                        </span>
                            new task
                        </router-link>
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
    </div>


</template>


<script>

    import {mapGetters} from 'vuex';

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

    .side-bar {
        /*border-right: 1px solid rgba(0,0,0,.1);*/
        /*height: 100%*/

    }

    .side-bar-title {

    }


    .router-link {
        display: block;
        /*padding: .25rem 1.5rem;*/
        /*font-size: 90%;*/
        color: rgba(0, 0, 0, .65);
    }

    .router-link:hover {
        text-decoration: none;
        font-weight: 900;
        color: black;
    }

    /*.side-bar-icon {*/
    /*    width: 14px;*/
    /*    margin: 3px 5px 4px 3px;*/
    /*}*/

    /*.side-bar-wizard {*/
    /*    width: 17px;*/
    /*    margin: 0px 2px 4px 0px;*/
    /*}*/

    /*.side-bar-note {*/
    /*    width: 19px;*/
    /*    margin: 1px 2px 3px 1px;*/
    /*}*/


</style>