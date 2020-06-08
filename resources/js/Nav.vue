<template>
    <div>
        <b-navbar toggleable="lg" class="nav-bar" >

            <a href="/"><i class="fas fa-home home-icon"></i></a>

            <span href="/" class="nav-title">{{getRouteName}}</span>


            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav v-if="authenticated">

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto" >

                    <b-nav-item-dropdown right v-if="user.isAdmin && authenticated">

                        <template v-slot:button-content>
                            <span>admin tools</span>
                        </template>
                        <b-dropdown-item href="/manage-tasks">manage tasks</b-dropdown-item>
                        <b-dropdown-item href="/manage-users">manage users</b-dropdown-item>
                        <b-dropdown-item href="/manage-jargons">manage jargons</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown right>

                        <template v-slot:button-content>
                            <span>me</span>
                        </template>
                        <b-dropdown-item href="/profile">edit profile</b-dropdown-item>
                        <b-dropdown-item href="/jots">check jots</b-dropdown-item>
                        <b-dropdown-item href="#" @click="signOut">sign out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>

</template>


<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        props: ['routeName'],
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user'
            }),
            getRouteName: function() {
                switch(this.routeName) {
                    case 'newTask':
                        // code block
                        return 'create a new task'
                    case 'newJargon':
                        // code block
                        return 'create a new jargon'
                    case 'editTask':
                        // code block
                        return 'edit task'
                    case 'profile':
                        // code block
                        return 'edit profile'
                    case 'adminTools':
                        // code block
                        return 'admin tools'
                    case 'tasks':
                        // code block
                        return 'manage tasks'
                    case 'users':
                        // code block
                        return 'manage users'
                    case 'userFolders':
                        // code block
                        return 'manage user folders'
                    case 'home':
                        // code block
                        return 'wayfinder'
                    case 'jots':
                        // code block
                        return 'my jots'
                    case 'userJots':
                        // code block
                        return 'jot'
                    default:
                    return 'wayfinder'
                }
            }
        },

        methods: {
            ...mapActions({
                signOutAction: 'auth/signOut'
            }),

            getName(){
                console.log(this.routeName)
            },

            signOut() {
                this.signOutAction().then(() => {
                    this.$router.replace({
                        name: 'signin'
                    })
                })
            },
            searchSubmit(){
                this.$router.replace({ name: 'search', query: { q: this.search } }).catch((err) => {
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

<style lang="scss">

    .nav-bar{
        background-color: white;
        -webkit-box-shadow: 0 0.25rem 0.125rem 0 rgba(0,0,0,0.05);
        box-shadow: 0 0.25rem 0.125rem 0 rgba(0,0,0,0.05);
        display: flex;
        align-content: space-evenly;

        .nav-title{
            font-size: 24px;
            font-weight: 700;
            margin: 10px 0;
            color: #495057;
            align-self: center;
        }
    }

    .home-icon{
        font-size: 24px;
        width: 53px;
        /*margin-left: 20px;*/
        color: #495057;
        text-align: center;
    }

    #nav-collapse{
        flex-grow: 0;
        .navbar-nav{
            float: right;
        }
    }

    @media (min-width: 999px){
        .navbar-expand-lg {
            justify-content: space-between;
        }
        .home-icon{
            width: 152px;
        }
    }



</style>
