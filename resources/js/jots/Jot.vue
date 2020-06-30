<template>

    <div>

        <b-row class="m-5" v-if="stepOne === true">
            <b-col xs="12" sm="4">
                <b-card bg-variant="success" text-variant="white" header=" "
                        header-html="<i class='fas fa-comments' style='font-size: 22px;'></i> "
                        class="text-center jot-card" @click="jotChoice('so about ')">
                    <b-card-text>comment</b-card-text>
                </b-card>
            </b-col>
            <b-col xs="12" sm="4">
                <b-card bg-variant="info" text-variant="white" header=" "
                        header-html="<i class='fas fa-question' style='font-size: 22px;'></i> "
                        class="text-center jot-card" @click="jotChoice('unsure about ')">
                    <b-card-text>unsure</b-card-text>
                </b-card>
            </b-col>
            <b-col xs="12" sm="4">
                <b-card bg-variant="warning" text-variant="white" header=" "
                        header-html="<i class='fas fa-times-circle' style='font-size: 22px;'></i> "
                        class="text-center jot-card" @click="jotChoice('stuck on ')">
                    <b-card-text>stuck</b-card-text>
                </b-card>
            </b-col>
        </b-row>

        <b-row class="m-1" v-if="stepTwo === true">
            <b-col xs="12">
                <b-form @submit="onSubmit">

                    <div class="form-group">
                        <label for="title">title</label>
                        <input type="text" class="form-control"
                               v-model="title">
                    </div>

                    <div class="form-group">
                        <label>content</label>
                        <froala :tag="'textarea'" :config="config" v-model="content"></froala>
                    </div>

<!--                    <b-form-group-->
<!--                            id="input-group-1"-->
<!--                    >-->
<!--                        <froala :tag="'textarea'" :config="config" v-model="content"></froala>-->
<!--                    </b-form-group>-->
                    <b-button class="float-right" size="xl" type="submit" variant="success">ask&nbsp;&nbsp;<i
                        class="fas fa-comment"></i></b-button>
                </b-form>
            </b-col>
        </b-row>

    </div>

</template>

<script>

    import axios from "axios";

    export default {
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
            jotChoice(choice) {
                // console.log(choice);
                this.stepOne = !this.stepOne;
                this.stepTwo = !this.stepTwo;
                console.log(choice);

                if(this.currentSlide.taskTitle){
                    this.title = choice + this.currentSlide.taskTitle;
                } else {
                    this.title = choice + this.currentSlide.title;
                }


                this.$emit('jot-choice', choice)
            },
            onSubmit(evt) {
                evt.preventDefault();
                let formData = {
                    title: this.title,
                    content: this.content,
                    jotable: this.currentSlide
                }

                axios.post('/jots', formData).then(response => {

                    //add to
                    console.log(this.response);

                }).catch(err => {
                    console.log(err);
                });
                console.log(this.content);
                console.log(this.currentSlide);
            },
        },
        props: ['currentSlide'],
        created(){
            console.log("this.currentSlide")
            console.log(this.currentSlide)
            console.log(this.choice)
        }
    }

</script>


<style>

    .jot-card {
        cursor: pointer;
    }

</style>
