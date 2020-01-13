<template>

    <form @submit.prevent="submit">
        {{form}}
        <div>
            <label for="email"></label>
            <input type="text" name="email" id="email" v-model="form.email">
        </div>

        <div>
            <label for="password"></label>
            <input type="password" name="password" id="password" v-model="form.password">
        </div>

        <div>
            <button type="submit">
                Sign in
            </button>
        </div>
    </form>

</template>

<script>

    import axios from 'axios';
    export default {
        name: 'signin',
        data() {
            return {
                form: {
                    email: "",
                    password: ""
                }

            }
        },
        components: {

        },
        methods: {
            async submit(){
                console.log("calling");
                let response = axios.post('auth/signin', this.form)

                console.log(response);
            }
        }
    }

</script>