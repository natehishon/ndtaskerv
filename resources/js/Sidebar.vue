<template>


    <div v-if="authenticated">
        <div>

            <p class="side-bar-title">Things</p>

            <ul class="side-bar-menu">

                <li v-for="link in sideBarLinks">
                    <i v-bind:class="link.icon"></i>
                    <router-link class="nav-brand mr-auto router-link" :to="{name: link.route}">{{link.title}}
                    </router-link>
                </li>

            </ul>

        </div>

        <div class="mt-2" v-if="user.isAdmin">

            <p class="side-bar-title">Admin Things</p>

            <ul class="side-bar-menu">

                <li v-for="link in adminSideBarLinks">
                    <i v-bind:class="link.icon"></i>
                    <router-link class="nav-brand mr-auto router-link" :to="{name: link.route}">{{link.title}}
                    </router-link>
                </li>

            </ul>

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