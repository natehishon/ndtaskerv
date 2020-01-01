<template>
    <div class="row">
        <div class="col-md-8"></div>
        <div class="card">
            <div class="card-body">
                <h2>{{task.title}}</h2>
                <article>{{task.content}}</article>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</template>

<script>
    export default {
        data(){
            //return an object
            return {
                task: null
            };
        },
        created(){
            axios.get(`/api/tasks/${this.$route.params.id}`).then(response => {
                this.task = response.data.data;
            });
        }
    }
</script>