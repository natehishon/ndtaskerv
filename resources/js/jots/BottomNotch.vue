<template>

    <div>

        <b-button variant="info" id="show-btn" @click="showModal">
            say something
            <i class="fas fa-comment fa-fw"></i></b-button>

        <b-modal ref="my-modal" hide-footer size="lg" title="make a jot" >
            <Jot v-on:jot-choice="changeTitle" :currentSlide="subTasks[currentSlide]" :choice="choice"></Jot>
        </b-modal>

    </div>

</template>

<script>
    import Jot from './Jot';

    export default {
        data(){
            return {
                choice: null,
            }
        },
        props: ['currentSlide', 'subTasks'],
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
        },
        mounted() {
            console.log("SKDFJSLKF")
            console.log(this.currentSlide);
        }
    }

</script>
