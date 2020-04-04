<template>
    <div>
        <!--        <div v-for="(slide, i) in subTasks">-->
        <!--            <span>{{slide.title}}</span>-->
        <!--        </div>-->
        {{subTask.title}}

        <v-runtime-template :template="'<div>' + subTask.description + '</div>'"/>
    </div>
</template>

<script>

    import VRuntimeTemplate from "v-runtime-template";
    import Jargon from '../jargons/Jargon';

    export default {
        components: {
            VRuntimeTemplate,
            Jargon
        },
        props: ['subTask'],
        data() {
            //return an object
            return {

            }
        }

    }
</script>

<style>


</style>