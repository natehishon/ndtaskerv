<template>
    <div v-if="sub_task">
        <!--        <div v-for="(slide, i) in subTasks">-->
        <!--            <span>{{slide.title}}</span>-->
        <!--        </div>-->
        {{sub_task.title}}

        <v-runtime-template :template="'<div>' + sub_task.content + '</div>'"/>
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
        props: ['sub_task'],
        data() {
            //return an object
            return {

            }
        },
        created(){
            console.log('yo');
            console.log(this.sub_task);
        }

    }
</script>

<style>


</style>