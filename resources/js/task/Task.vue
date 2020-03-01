<template>
    <!--    <div class="row">-->
    <!--        <div class="col-xs-12">-->

<!--    <b-container fluid v-if="authenticated" no-gutters="true" style="height: 100%;">
            <b-row no-gutters="true">
                <b-col cols="12" sm="2" lg="2"  class="side-bar-column">
                    <Sidebar class="sidebar"></Sidebar>
                </b-col>
                <b-col cols="12" sm="10"  lg="10" class="router-view" >
                    <router-view></router-view>
                </b-col>
            </b-row>
        </b-container>-->
    <div class="card">
        <div class="card-body">
            <b-row>
                <b-col cols="12">
                    <h2>{{task.title}}</h2>
                    <article v-html="task.content"></article>



                    <div v-for="(tag, index) in task.task_tag">

                        <b-button variant="light" v-b-popover.hover.click.blur.top="tag.content"
                                  title="Helper Tag">
                            {{tag.title}}
                        </b-button>
                        <!--                {{tag.title}}-->
                        <!--                {{tag.content}}-->
                        <!--                {{index}}-->
                    </div>
                </b-col>
                <b-col cols="6">
                </b-col>
            </b-row>

            <b-row>
                <b-col cols="12">
                    <div class="slides-container">
                        <vueper-slides :transitionSpeed="1" :infinite="false" :touchable="false" fractions progress
                                       ref="myVueperSlides">
                            <vueper-slide v-for="(slide, i) in subTasks" :key="i" :title="slide.title">
                                <template v-slot:content>
                                    <div class="vueperslide__content-wrapper">
                                        <strong>{{ slide.title }}</strong>
                                        <img v-bind:src="slide.cover"  style="width: 100px; height: 100px;" alt=""><br>
                                        <p>{{slide.description}}</p>
                                    </div>
                                </template>
                                <!--                            <template v-slot:bullet="{ active, slideIndex, index }">-->
                                <!--                                <i class="icon">{{ active ? 'check_circle' : 'radio_button_unchecked' }}</i>-->
                                <!--                            </template>-->
                            </vueper-slide>
                            <template v-slot:bullet="{ active, slideIndex, index }" v-bind:class="{ active: isActive }">
                                <i class="icon" v-bind:class="{ 'bullet-active': active }">{{index}}</i class="icon">
                                <!--                    <span>{{index}}</span>-->
                            </template>
                        </vueper-slides>
                    </div>
                </b-col>
            </b-row>


<!--            <img v-bind:src="task.imagePath + task.imageUrl" style="width: 200px;"/>-->
        </div>


        <!--                <div class="sub-task">-->
        <!--                    {{subTasks[currentIndex].name}}-->
        <!--                    {{subTasks[currentIndex].description}}-->
        <!--                </div>-->


        <!--                <button @click="$refs.myVueperSlides.goToSlide(4, { animation: false })">Next</button>-->




    </div>
    <!--        </div>-->
    <!--        &lt;!&ndash;        <div class="col-md-4 pb-4">&ndash;&gt;-->
    <!--        &lt;!&ndash;            <Availability></Availability>&ndash;&gt;-->
    <!--        &lt;!&ndash;        </div>&ndash;&gt;-->

    <!--    </div>-->
</template>

<script>

    import Availability from "./Availability";
    import coverflow from 'vue-coverflow'
    import {VueperSlides, VueperSlide} from 'vueperslides'

    export default {
        components: {
            Availability,
            coverflow,
            VueperSlide,
            VueperSlides

        },
        props: ['task'],
        data() {
            //return an object
            return {
                task: null,
                subTasks: [
                    {
                        cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/025.png',
                        title: 'Pikachu',
                        content: 'Subtask one',
                        description: 'Whenever Pikachu comes across something new, it blasts it with a jolt of electricity. If you come across a blackened berry, it\'s evidence that this Pokémon mistook the intensity of its charge.',
                        url: "/"
                    },
                    {
                        cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/007.png',
                        title: 'Squirtle',
                        content: 'Subtask one',
                        description: 'Squirtle\'s shell is not merely used for protection. The shell\'s rounded shape and the grooves on its surface help minimize resistance in water, enabling this Pokémon to swim at high speeds.',
                        url: "/"
                    },
                    {
                        cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/001.png',
                        title: 'Bulbasaur',
                        content: 'Subtask one',
                        description: 'Bulbasaur can be seen napping in bright sunlight. There is a seed on its back. By soaking up the sun\'s rays, the seed grows progressively larger..',
                        url: "/"
                    },
                    {
                        cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/004.png',
                        title: 'Charmander',
                        content: 'Subtask one',
                        description: 'The flame that burns at the tip of its tail is an indication of its emotions. The flame wavers when Charmander is enjoying itself. If the Pokémon becomes enraged, the flame burns fiercely.',
                        url: "/"
                    },
                    {
                        cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/133.png',
                        title: 'Eevee',
                        content: 'Subtask one',
                        description: 'Eevee has an unstable genetic makeup that suddenly mutates due to the environment in which it lives. Radiation from various stones causes this Pokémon to evolve.',
                        url: "/"
                    },
                    {
                        cover: 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/147.png',
                        title: 'Dratini',
                        content: 'Subtask one',
                        description: 'Dratini continually molts and sloughs off its old skin. It does so because the life energy within its body steadily builds to reach uncontrollable levels.',
                        url: "/"
                    },


                ],
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
            console.log("here");
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
            }
        }
    }
</script>

<style>

    button:focus{
        outline:none!important;
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
    .vueperslides__arrow {color: gray}

    .icon{
        font-style:normal;
    }

    .bullet-active{
        font-weight: 900;
    }
</style>