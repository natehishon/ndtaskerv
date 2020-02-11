<template>
    <div class="card w-100">
        <div class="card-body">
            <!--            <router-link :to="{ name: 'task', params: {id} }">-->
            <h5 class="card-title">{{title}}</h5>
<!--            <b-badge v-b-popover.hover.top="'I am popover directive content!'">Tag</b-badge>-->
<!--            <b-button v-b-popover.hover.top="'I am popover directive content!'" title="Popover Title">-->
<!--                Hover Me-->
<!--            </b-button>-->
            <!--            </router-link>-->
            <p class="card-text">{{content}}</p>
        </div>

    </div>
</template>

<script>
    export default {
        props: {title: String, content: String, id: Number},
        created() {
            $('[data-toggle="popover"]').popover()
            Vue.nextTick(function () {

            })
        }
    }
</script>