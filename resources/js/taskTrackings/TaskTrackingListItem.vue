<template>
    <div class="card w-100">
        <div class="card-body">
            <router-link :to="{ name: 'mytask', params: {id} }">
                <h5 class="card-title">{{tasks.title}}</h5>
            </router-link>
            <p class="card-text">{{tasks.content}}</p>
        </div>

    </div>
</template>

<script>
    export default {
        props: {tasks:Object, id:Number}
    }
</script>