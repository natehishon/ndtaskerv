<template>


    <div class="card">
        <div class="card-body">
            <b-row>
                <b-col cols="12">
                    <h2>{{task.title}}</h2>
                    <v-runtime-template :template="'<div>' + task.content + '</div>'"/>
                </b-col>
            </b-row>

            <b-row>
                <b-col cols="12">
                    <div class="slides-container">

                        <subTaskSlideShow v-on:slide-change="slideChange"
                                          v-bind:sub_tasks="task.sub_task"></subTaskSlideShow>

                    </div>
                </b-col>
            </b-row>

        </div>

    </div>

</template>

<script>

    import Jargon from '../jargons/Jargon';
    import SubTaskSlideShow from '../subTask/SubTaskSlideShow'
    import VRuntimeTemplate from "v-runtime-template";

    export default {
        components: {
            SubTaskSlideShow,
            Jargon,
            VRuntimeTemplate,

        },
        props: ['task'],
        data() {
            //return an object
            return {
                // task: null,
                // subTasks: [
                //     {
                //         cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/025.png',
                //         title: 'Step One',
                //         content: 'Subtask one',
                //         description: '<p>Whenever Pikachu comes across something new, it blasts it with a jolt of <jargon>first jargon</jargon>. If you come across a blackened berry, it\'s evidence that this <jargon>second jargon</jargon> mistook the intensity of its charge.</p>',
                //         url: "/"
                //     },
                //     {
                //         cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/007.png',
                //         title: 'Squirtle',
                //         content: 'Subtask one',
                //         description: 'Squirtle\'s shell is not merely used for protection. The shell\'s rounded shape and the grooves on its surface help minimize resistance in water, enabling this Pokémon to swim at high speeds.',
                //         url: "/"
                //     },
                //     {
                //         cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/001.png',
                //         title: 'Bulbasaur',
                //         content: 'Subtask one',
                //         description: 'Bulbasaur can be seen napping in bright sunlight. There is a seed on its back. By soaking up the sun\'s rays, the seed grows progressively larger..',
                //         url: "/"
                //     },
                //     {
                //         cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/004.png',
                //         title: 'Charmander',
                //         content: 'Subtask one',
                //         description: 'The flame that burns at the tip of its tail is an indication of its emotions. The flame wavers when Charmander is enjoying itself. If the Pokémon becomes enraged, the flame burns fiercely.',
                //         url: "/"
                //     },
                //     {
                //         cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/133.png',
                //         title: 'Eevee',
                //         content: 'Subtask one',
                //         description: 'Eevee has an unstable genetic makeup that suddenly mutates due to the environment in which it lives. Radiation from various stones causes this Pokémon to evolve.',
                //         url: "/"
                //     },
                //     {
                //         cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/147.png',
                //         title: 'Dratini',
                //         content: 'Subtask one',
                //         description: 'Dratini continually molts and sloughs off its old skin. It does so because the life energy within its body steadily builds to reach uncontrollable levels.',
                //         url: "/"
                //     },
                //
                //
                // ],
                number: 500,
                window: {
                    width: 0,
                    height: 0
                },
                currentIndex: 0,

            };
        },
        created() {
            // axios.get(`tasks/${this.$route.params.id}`).then(response => {
            //     this.task = response.data.data;
            //
            //     // this.subTasks = response.data.data.sub_task;
            // });
            console.log('12');
            console.log(this.task.sub_task);
            // $('[data-toggle="popover"]').popover()
            // Vue.nextTick(function () {
            //
            // })
        },
        methods: {
            onTermChange(index) {
                this.currentIndex = index;

            },
            increase() {
                this.number += 100
            },
            slideChange(event) {
                this.$emit('task-slide', event)
            }
        },
        computed: {
            // a computed getter
            taskTemplate: function () {
                // `this` points to the vm instance
                return '<div>' + this.task.content + '</div>'
            }
        },
    }
</script>

<style>

    button:focus {
        outline: none !important;
    }

    .vueperslides__progress {
        background: rgba(0, 0, 0, 0.25);
        color: #D7FCF9;
    }

    .slides-container {
        /*max-width: 500px;*/
        /*min-width: 500px;*/
    }

    .vueperslides__bullet .default {
        background-color: rgba(0, 0, 0, 0.3);
        border: none;
        box-shadow: none;
        transition: 0.3s;
        width: 16px;
        height: 16px;
    }

    .vueperslides__bullet--active .default {
        background-color: #42b983;
        outline: none;
    }

    .vueperslides__bullet span {
        display: block;
        color: #fff;
        font-size: 10px;
        opacity: 0.8;
    }

    .vueperslides__arrow {
        color: gray
    }

    .icon {
        font-style: normal;
    }

    .bullet-active {
        font-weight: 900;
        color: blue;
    }

</style>