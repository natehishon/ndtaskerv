<template>


    <div class="jargon">


        <b-button :id="time" size="sm" v-bind:variant="jargon.color" class="jargon-button">
            <div class="slot-wrapper">
                <slot></slot>
            </div>
        </b-button>
        <b-popover :target="time" triggers="hover blur click" placement="top" >

                <b-row>

                    <b-col xs="6">
                        <v-runtime-template :template="'<div>' + jargon.content + '</div>'"/>
                    </b-col>

                    <b-col xs="6">

                            <b-img v-bind:src="jargon.imageUrl" @click="openNewTab(jargon.imageUrl)" fluid
                                   style="cursor: pointer" class="jargon-image"></b-img>


                    </b-col>
            </b-row>
<!--            <span v-html="jargon.content"></span>-->

        </b-popover>


    </div>


</template>

<script>

    import axios from 'axios';
    import VRuntimeTemplate from "v-runtime-template";

    export default {
        name: 'jargon',
        components: {
            VRuntimeTemplate,
        },
        data() {
            return {
                searchTag: "",
                jargon: null,
                time: null
            }
        },
        mounted() {

            this.searchTag = this.$slots.default[0].text;
            const request = axios.get("jargons/find/" + this.searchTag).then(response => {
                this.jargon = response.data.data;
                this.loading = false;
            })

        },
        created() {
            let d = new Date();
            this.time = d.getTime().toString();
        },
        methods: {
            closePop(id) {
                this.$root.$emit('bv::hide::popover', 'popover-' + id)
            },
            openNewTab(url) {
                window.open(url, "_blank");
            }
        }
    }

</script>

<style lang="scss">

    .jargon-image{
        max-width: 100px;
        max-height: 100px;
    }

    /*.jargon-button{*/
    /*    color: blue;*/
    /*    background-color: white;*/
    /*}*/

    /*.jargon-button{*/
    /*    color: blue;*/
    /*    background-color: white;*/
    /*}*/

    .jargon {
        display: inline-block;

    .slot-wrapper {
        font-weight: 700;
    }

    }

</style>
