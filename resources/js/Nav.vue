<template>
    <div>
        <b-navbar toggleable="lg" class="nav-bar">

            <a href="/" v-if="authenticated">
                <i class="fas fa-home home-icon" :class="user.isAdmin ? 'home-admin' : 'home-user'"></i>
            </a>

            <span href="/" class="nav-title">{{getRouteName}}
                <i id="nav-pop" class="fas fa-info-circle" style="font-size: 20px; cursor: pointer"></i>
                <b-popover target="nav-pop" triggers="hover blur" placement="top">

            <b-row>

                    <b-col xs="12">
                        <span>{{infoText}}</span>
                    </b-col>
            </b-row>

        </b-popover>
            </span>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav v-if="authenticated">

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">

                    <b-nav-item-dropdown right v-if="user.isAdmin && authenticated">

                        <template v-slot:button-content>
                            <span>admin tools</span>
                        </template>
                        <b-dropdown-item href="/manage-tasks">manage tasks</b-dropdown-item>
                        <b-dropdown-item href="/manage-users">manage users</b-dropdown-item>
                        <!--                        <b-dropdown-item href="/prebuilt-folders">prebuilt folders</b-dropdown-item>-->
                        <b-dropdown-item href="/manage-jots">manage jots</b-dropdown-item>
                        <b-dropdown-item href="/manage-jargons">manage jargons</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown right>

                        <template v-slot:button-content>
                            <span>me</span>
                        </template>
                        <b-dropdown-item href="/profile">edit profile</b-dropdown-item>
                        <b-dropdown-item href="/jots">check jots</b-dropdown-item>
                        <b-dropdown-item href="/jargons">check jargons</b-dropdown-item>
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
            getRouteName: function () {
                switch (this.routeName) {
                    case 'jargons':
                        // code block
                        this.infoText = "Jargons are terms with a specific meaning in this workplace context/setting. You can check them out here.";
                        return 'jargons'
                    case 'manageJots':
                        this.infoText = "Manage jots here: comment on jot questions/comments posted by users.";
                        return 'manage jots'
                    case 'manageJargons':
                        this.infoText = "Manage jargons here: create new jargons for terms/ideas that might benefit from further information and clarification.";
                        return 'manage jargons'
                    case 'newTask':
                        // code block
                        this.infoText = "Create a new task here: the content section will serve as the main description of the task and will be displayed at the beginning of the task(along with the chosen task media). Create task steps to guide a user through this task.";
                        return 'create a new task'
                    case 'newJargon':
                        // code block
                        return 'create a new jargon'
                    case 'editTask':
                        // code block
                        this.infoText = "Edit an existing task here: the content section will serve as the main description of the task and will be displayed at the beginning of the task(along with the chosen task media). Create task steps to guide a user through this task.";
                        return 'edit task'
                    case 'profile':
                        this.infoText = "Edit some profile options here.";
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
                        this.infoText = "Manager users here, this includes an option to manage a particular user's folder structure: options > user folders.";
                        return 'manage users'
                    case 'userFolders':
                        this.infoText = "Manager user folders here: create a new folder for a user and assign tasks to that folder.";
                        return 'manage user folders'
                    case 'home':
                        return 'wayfinder'
                    case 'jots':
                        this.infoText = "Jots are questions or comments about a task or sub task, you can click on options > check jots to ask further questions and see response.";
                        return 'jots'
                    case 'userJots':
                        // code block
                        return 'jot'
                    default:
                        this.infoText = "wayfinder is an application designed to help you succeed at work! Click on folders to open them and click on tasks to launch them. You can also search for something you can't find.";
                        return 'wayfinder'
                }
            }
        },

        methods: {
            ...mapActions({
                signOutAction: 'auth/signOut'
            }),

            getName() {
            },

            signOut() {
                this.signOutAction().then(() => {
                    this.$router.replace({
                        name: 'signin'
                    })
                })
            },
            searchSubmit() {
                this.$router.replace({name: 'search', query: {q: this.search}}).catch((err) => {
                    this.$emit('search')
                });
                this.$emit('created');

            }
        },
        data() {
            return {
                search: '',
                infoText: "wayfinder is an application designed to help you succeed at work! Click on folders to open them and click on tasks to launch them. You can also search for something you can't find.",
            }
        },
        mounted() {
            this.search = this.$route.query.q;
        }
    }

</script>

<style lang="scss">

    .nav-bar {
        background-color: white;
        -webkit-box-shadow: 0 0.25rem 0.125rem 0 rgba(0, 0, 0, 0.05);
        box-shadow: 0 0.25rem 0.125rem 0 rgba(0, 0, 0, 0.05);
        display: flex;
        align-content: space-evenly;

        .nav-title {
            font-size: 24px;
            font-weight: 700;
            margin: 10px auto;
            color: #495057;
            align-self: center;
        }
    }

    .home-admin{
        width: 153px;
    }

    .home-user{
        width: 24px;
        margin-left: 25px;
    }

    .home-icon {
        font-size: 24px;
        /*margin-left: 20px;*/
        color: #495057;
        text-align: center;
    }

    #nav-collapse {
        flex-grow: 0;

        .navbar-nav {
            float: right;
        }
    }

    @media (min-width: 999px) {
        .navbar-expand-lg {
            justify-content: space-between;
        }
        .home-icon {
            /*width: 152px;*/
        }
    }


</style>
