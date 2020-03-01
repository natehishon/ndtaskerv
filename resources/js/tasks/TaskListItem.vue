<template>
    <div class="card w-100">
        <div class="card-body">
            <!--            <router-link :to="{ name: 'task', params: {id} }">-->
            <h5 class="card-title">{{task.title}}</h5>
<!--            <b-badge v-b-popover.hover.top="'I am popover directive content!'">Tag</b-badge>-->




            <!--            </router-link>-->
            <p class="card-text">{{task.content}}</p>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['task'],
        created() {
            $('[data-toggle="popover"]').popover()
            Vue.nextTick(function () {


            })
        },
        methods:{
            onClick(event) {
                event.stopPropagation()
            },
            onClickOutside() {
                console.log("yo");
            }
        }
    }
</script>