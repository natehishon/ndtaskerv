<template>

    <div>

        <b-button id="show-btn" @click="showModal">say something</b-button>

        <b-modal ref="my-modal" hide-footer size="lg" :title="choice" >
            <Jot v-on:jot-choice="changeTitle" :currentSlide="currentSlide"></Jot>
        </b-modal>

    </div>

</template>

<script>
    import Jot from './Jot';

    export default {
        data(){
            return {
                choice: "what type of something?",
            }
        },
        props: ['currentSlide'],
        components: {
          Jot
        },
        methods: {
            showModal() {
                this.$refs['my-modal'].show()
            },
            changeTitle(event) {
                this.choice = event;
            }
        }
    }

</script>
