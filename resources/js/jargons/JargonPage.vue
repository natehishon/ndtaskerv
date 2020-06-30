<template>

    <div class="jargon-page-container">

        <div v-if="jargon.image_url" class="jargon-page-image-container">
            <div style="margin: 0 40px ">
                <v-runtime-template :template="'<div>' + jargon.content_html + '</div>'"/>
            </div>
            <b-img v-bind:src="jargon.image_url" @click="openNewTab(jargon.image_url)" fluid
                   style="cursor: pointer; margin: 0 40px"></b-img>
        </div>


        <div v-if="!jargon.image_url" class="jargon-page-no-image-container">
            <v-runtime-template :template="'<div>' + jargon.content_html + '</div>'"/>
        </div>


    </div>
</template>

<style>


</style>

<script>


    import axios from "axios";
    import VRuntimeTemplate from "v-runtime-template";

    export default {
        name: 'jargonPage',
        data() {
            return {
                jargon: null
            }
        },
        components: {
            VRuntimeTemplate,
        },
        methods: {},
        created() {
            const request = axios.get("jargons/" + this.$route.params.id).then(response => {
                this.jargon = response.data.data;
                console.log(this.jot)
            })
        }
    }

</script>

<style lang="scss">

    .jargon-page-container {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: center;

        font-size: 1.25rem;
        font-weight: 600;

        .jargon-page-image-container {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
        }
    }

</style>
