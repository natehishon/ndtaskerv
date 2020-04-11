<template>

    <div>

        <b-row class="m-5" v-if="stepOne === true">
            <b-col xs="12" sm="4">
                <b-card bg-variant="info" text-variant="white" header=" "
                        header-html="<i class='fas fa-comment' style='font-size: 22px;'></i> "
                        class="text-center jot-card" @click="jotChoice('leave a comment/anything')">
                    <b-card-text>comment</b-card-text>
                </b-card>
            </b-col>
            <b-col xs="12" sm="4">
                <b-card bg-variant="warning" text-variant="white" header=" "
                        header-html="<i class='fas fa-question' style='font-size: 22px;'></i> "
                        class="text-center jot-card" @click="jotChoice('unsure about something')">
                    <b-card-text>unsure</b-card-text>
                </b-card>
            </b-col>
            <b-col xs="12" sm="4">
                <b-card bg-variant="danger" text-variant="white" header=" "
                        header-html="<i class='fas fa-times-circle' style='font-size: 22px;'></i> "
                        class="text-center jot-card" @click="jotChoice('stuck on something')">
                    <b-card-text>stuck</b-card-text>
                </b-card>
            </b-col>
        </b-row>

        <b-row class="m-5" v-if="stepTwo === true">
            <b-col xs="12">
                {{currentSlide.modelName}}
                <b-form @submit="onSubmit">
                    <b-form-group
                            id="input-group-1"
                    >
                        <froala :tag="'textarea'" :config="config" v-model="content"></froala>
                    </b-form-group>
                    <b-button type="submit" variant="dark">submit</b-button>
                </b-form>
            </b-col>
        </b-row>

    </div>

</template>

<script>

    export default {
        data() {
            return {
                stepOne: true,
                stepTwo: false,
                content: null,
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
                this.$emit('jot-choice', choice)
            },
            onSubmit(evt) {
                evt.preventDefault();
                alert(JSON.stringify(this.form))
            },
        },
        props: ['currentSlide'],
        created(){
            console.log(this.currentSlide)
        }
    }

</script>


<style>

    .jot-card {
        cursor: pointer;
    }

</style>