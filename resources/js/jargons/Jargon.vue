<template>


    <div class="jargon">


        <b-button :id="time" size="sm" v-bind:variant="jargon.color">
            <div class="slot-wrapper">
                <slot></slot>
            </div>
        </b-button>
        <b-popover :target="time" triggers="hover blur click" placement="top" :title="jargon.title">

            {{jargon.content}}
            <br>
            <a href="https://www.w3schools.com/html/">Visit our HTML tutorial</a>
        </b-popover>


    </div>


</template>

<script>

    import axios from 'axios';

    export default {


        data() {
            return {
                searchTag: "",
                jargon: null,
                time: null
            }
        },
        mounted() {

            this.searchTag = this.$slots.default[0].text;
            const request = axios.get("jargons/" + this.searchTag).then(response => {
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
            }
        }
    }

</script>

<style lang="scss">

    .jargon {
        display: inline-block;

    .slot-wrapper {
        font-weight: 700;
    }

    }

</style>