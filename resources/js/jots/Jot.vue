<template>

    <div>

        <b-row class="m-5 jot-cards" v-if="stepOne === true">
            <b-col xs="12" sm="4">
                <b-card bg-variant="success" text-variant="white" header=" "
                        header-html="<i class='fas fa-comments' style='font-size: 1.5rem;'></i> "
                        class="text-center jot-card" @click="jotChoice('so about ')">
                    <b-card-text>comment</b-card-text>
                </b-card>
            </b-col>
            <b-col xs="12" sm="4">
                <b-card bg-variant="info" text-variant="white" header=" "
                        header-html="<i class='fas fa-question' style='font-size: 1.5rem;'></i> "
                        class="text-center jot-card" @click="jotChoice('unsure about ')">
                    <b-card-text>unsure</b-card-text>
                </b-card>
            </b-col>
            <b-col xs="12" sm="4">
                <b-card bg-variant="warning" text-variant="white" header=" "
                        header-html="<i class='fas fa-times-circle' style='font-size: 1.5rem;'></i> "
                        class="text-center jot-card" @click="jotChoice('stuck on ')">
                    <b-card-text>stuck</b-card-text>
                </b-card>
            </b-col>
        </b-row>

        <b-row class="m-1" v-if="stepTwo === true">
            <b-col xs="12">
                <b-form @submit="onSubmit" class="way-form">

                    <div class="form-group">
                        <label for="title">jot title:</label>
                        <input type="text" class="form-control"
                               v-model="title">
                    </div>

                    <div class="form-group">
                        <label>jot content:</label>
                        <froala :tag="'textarea'" :key="'nQE2uD1C2F2B1A1C1lfedB1bwnC-16ptF-11yoB2F-7ewD-13C3B2E2G2E3B1A1C7E2E2=='" :attribution="false" :config="config" v-model="content"></froala>
                    </div>

                    <b-button class="float-right large-button "  size="xl" type="submit" variant="success">ask&nbsp;&nbsp;<i
                        class="fas fa-comment"></i></b-button>
                    <b-button class="float-right large-button mr-2 " @click="backJot" size="xl" variant="secondary">back&nbsp;&nbsp;<i
                        class="fas fa-chevron-left"></i></b-button>
                </b-form>
            </b-col>
        </b-row>


    </div>

</template>

<script>

    import axios from "axios";

    export default {
        components:{
        },
        data() {
            return {
                stepOne: true,
                stepTwo: false,
                content: null,
                choice: null,
                title: null,
                config: {
                    colorsStep: 6,
                    colorsText: [
                        '#15E67F', '#E3DE8C', '#D8A076', '#D83762', '#76B6D8', 'REMOVE',
                        '#1C7A90', '#249CB8', '#4ABED9', '#FBD75B', '#FBE571', '#FFFFFF'
                    ],
                    events: {
                        'froalaEditor.initialized': function () {
                            console.log('initialized')
                        }
                    },
                    quickInsertTags: [],
                    toolbarButtons: ['emoticons'],
                    // htmlAllowedStyleProps: ['font-family', 'font-size', 'background', 'color', 'width', 'text-align', 'vertical-align', 'background-color', 'float'],
                    paragraphFormatSelection: true,
                    refreshAfterCallback: true,
                    htmlUntouched: true,
                    // imageEditButtons: ['replaceImage', 'imageDisplay', 'imageAlign', 'imageRemove'],
                    // linkEditButtons: ['linkOpen', 'linkRemove'],
                    // linkNoReferrer: false,
                    htmlAllowedTags: ['.*', 'jargon'],
                    htmlRemoveTags: ['']
                },
            }
        },
        methods: {
            backJot(){
                this.stepOne = !this.stepOne;
                this.stepTwo = !this.stepTwo;

            },
            jotChoice(choice) {
                // console.log(choice);
                this.stepOne = !this.stepOne;
                this.stepTwo = !this.stepTwo;

                if(this.currentSlide != null){
                    if(this.currentSlide.taskTitle){
                        this.title = choice + this.currentSlide.taskTitle;
                    } else {
                        this.title = choice + this.currentSlide.title;
                    }
                }


                if(this.jargon){
                    console.log(this.jargon);
                    this.title = choice + this.jargon.title;
                }


                this.$emit('jot-choice', choice)
            },
            onSubmit(evt) {
                evt.preventDefault();
                let formData = {};
                if(this.currentSlide){
                    formData = {
                        title: this.title,
                        content: this.content,
                        jotable: this.currentSlide
                    }
                }

                if(this.jargon){
                    formData = {
                        title: this.title,
                        content: this.content,
                        jotable: this.jargon
                    }
                }

                axios.post('jots', formData).then(response => {

                    this.$bvModal.hide("jotModal");

                    this.showSuccess()
                    // this.$refs.jotSuccessId.show();

                }).catch(err => {
                    console.log(err);
                });
            },
        },
        props: ['currentSlide', 'jargon', 'showSuccess'],

    }

</script>


<style lang="scss">

    .jot-card {
        cursor: pointer;
    }

    .jot-cards{
        .card-text{
            font-size: 1.25rem;

        }
    }

</style>
