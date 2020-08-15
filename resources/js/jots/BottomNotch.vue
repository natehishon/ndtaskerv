<template>

    <div>

        <div v-if="currentSlide != null">

            <b-button variant="info" id="show-btn" @click="showModal" class="large-button">
                <i class="fas fa-comment fa-fw"></i>&nbsp;question/comment
            </b-button>

            <b-modal id="jotModal" ref="jotModal" hide-footer size="lg">
                <template v-slot:modal-title>
                    <i id="jot-pop" class="fas fa-info-circle" style="font-size: 20px; cursor: pointer"></i>
                    make a jot
                    <b-popover target="jot-pop" triggers="hover blur" placement="top">
                        <b-row>
                            <b-col xs="12">
                                <span>Jots(definition: to write or mark down quickly or briefly) are questions or comments about a task, task step, etc. You can click on a type to give a little context about your jot and use the form(and emojis!) to express your thought.</span>
                            </b-col>
                        </b-row>
                    </b-popover>
                </template>
                <Jot v-on:jot-choice="changeTitle" :show-success="showSuccess" :current-slide="subTasks[currentSlide]" :choice="choice"></Jot>
            </b-modal>

        </div>

        <div v-if="jargon">

            <b-button variant="info" id="show-jargon" @click="showModal" class="large-button">
                question/comment
                <i class="fas fa-comment fa-fw"></i></b-button>

            <b-modal id="jotModal" ref="jotModal" hide-footer size="lg" title="make a jot">
                <Jot :jargon="jargon"></Jot>
            </b-modal>

        </div>

        <success-modal id="jotSuccessId" :uniqueId="'jotSuccessId'" :ref="'jotSuccessId'"></success-modal>

    </div>

</template>

<script>
    import Jot from './Jot';
    import SuccessModal from "../miscellaneous/SuccessModal";

    export default {
        data() {
            return {
                choice: null,
            }
        },
        props: ['currentSlide', 'subTasks', 'jargon'],
        components: {
            Jot,
            SuccessModal
        },
        methods: {
            showModal() {
                this.$refs['jotModal'].show()
            },
            showSuccess(){
                console.log("here");
                this.$refs.jotSuccessId.show();
            },
            changeTitle(event) {
                this.choice = event;
            }
        },
        mounted() {
        }
    }

</script>
