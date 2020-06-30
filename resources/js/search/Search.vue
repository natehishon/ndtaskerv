<template>
    <div >

        <div class="tasks-container mt-3" v-if="loading === false">
            <h5>favorites</h5>
            <ul v-if="favorites.length > 0">
                <li v-for="favorite in favorites">
                    <b-button class="m-1" variant="success" v-on:click="chooseFavorite(favorite)">title:
                        {{favorite.searchable.title}} content: {{favorite.searchable.content}}
                    </b-button>
                </li>
            </ul>
            <span v-if="favorites.length === 0">no favorite results</span>
        </div>


        <div class="tasks-container mt-3" v-if="loading === false">
            <h5>folders</h5>
                        <ul v-if="folders.length > 0">
                            <li v-for="folder in folders">
                                <b-button class="m-1" variant="success" v-on:click="chooseFavorite(folder)">title: {{folder.title}}</b-button>
                            </li>
                        </ul>
            <span v-if="folders.length === 0">no folder results</span>
        </div>

        <div class="tasks-container mt-3" v-if="loading === false">
            <h5>tasks</h5>
            <ul v-if="tasks.length > 0">
                <li v-for="task in tasks">
                    <b-button class="m-1" v-on:click="choose(task)" variant="primary">title: {{ task.title }}
                        content: {{ task.content }}
                    </b-button>

                    <br>
                </li>
            </ul>
            <span v-if="tasks.length === 0">no task results</span>
        </div>


        <div class="tasks-container mt-3" v-if="loading === false">
            <h5>jargons</h5>
            <ul v-if="jargons.length > 0">
                <li v-for="jargon in jargons">
                    <b-button class="m-1" v-on:click="choose(jargon)" variant="info">title: {{ jargon.title }}
                        content: {{ jargon.content }}
                    </b-button>

                    <br>
                </li>
            </ul>
            <span v-if="jargons.length === 0">no jargon results</span>
        </div>

        <div class="tasks-container mt-3" v-if="loading === false">
            <h5>jots</h5>
                        <ul v-if="jots.length > 0">
                            <li v-for="jot in jots">
                                <b-button class="m-1" variant="success" v-on:click="chooseFavorite(jot)">title: {{jot.title}} content: {{jot.content}}</b-button>
                            </li>
                        </ul>
                        <span v-if="jots.length === 0">no jot results</span>
        </div>

        <div class="loader" v-if="loading === true">loading...
        </div>
    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        data() {
            //return an object
            return {
                form: {},
                tasks: [],
                favorites: [],
                folders: [],
                jargons: [],
                jots: [],
                loading: false,

            }
        },
        props: ['search'],
        mounted() {
            // console.log(this.search)
        },
        created() {
            this.loading = true;
            this.form.search = this.search;

            axios.post('/search/user-search', this.form).then(response => {
                this.loading = false;

                console.log(response.data);
                this.tasks = response.data.tasks;
                this.jargons = response.data.jargons;
                this.favorites = response.data.history;
                this.folders = response.data.folders;
                this.jots = response.data.jots;

                console.log(this.favorites);

            }).catch(err => {
                console.log(err);
            });
        },
        methods: {

            chooseFavorite(favorite) {
                console.log(favorite);
                axios.post('/search/history-choice', favorite).then(response => {
                    console.log(response);
                    console.log('pretend I am routing away');
                    this.$router.push({path: '/'})
                });
            },

            choose(choice) {
                console.log(choice);
                this.form.choice = choice;
                axios.post('/search/user-choice', this.form).then(response => {
                    // this.loading = false;
                    console.log("yo");
                    console.log(response.data);
                    this.$router.push({path: '/'})
                    // this.results = response.data;

                }).catch(err => {
                    console.log(err);
                });
            }
        }
    };
</script>
