<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <h2>{{task.title}}</h2>
                    <article>{{task.content}}</article>
                </div>
            </div>
        </div>
        <div class="col-md-4 pb-4">
            <Availability></Availability>
        </div>

    </div>
</template>

<script>

    import Availability from "./Availability";

    export default {
        components: {
            Availability
        },
        data() {
            //return an object
            return {
                task: null
            };
        },
        created() {
            axios.get(`/api/tasks/${this.$route.params.id}`).then(response => {
                this.task = response.data.data;
            });
        }
    }
</script>