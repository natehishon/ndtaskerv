<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <h2>{{task.title}}</h2>
                    <article>{{task.content}}</article>
                </div>
                <div>
                    <ul id="example-1">
                        <li v-for="sub in subTasks">
                            {{ sub.title }}<br>
                            {{ sub.content }}
                        </li>
                    </ul>
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
                task: null,
                subTasks: null
            };
        },
        created() {
            axios.get(`tasks/${this.$route.params.id}`).then(response => {
                this.task = response.data.data;
                this.subTasks = response.data.data.sub_task;
            });
        }
    }
</script>