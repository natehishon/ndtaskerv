<template>

    <div class="sign-in-container">


            <b-card class="mt-5"
                    header="way finder log in"
                    header-tag="header"
            >

                        <b-form style="min-width:500px" @submit.prevent="submit">
                            <b-form-group
                                    id="input-group-1"
                                    label="Email address:"
                                    label-for="input-1"
                                    description=""
                            >
                                <b-form-input
                                        id="input-1"
                                        v-model="form.email"
                                        type="email"
                                        required
                                        placeholder="Enter email"
                                ></b-form-input>
                            </b-form-group>

                            <b-form >
                            <label for="text-password">Password</label>
                            <b-input type="password" id="text-password" v-model="form.password" aria-describedby="password-help-block"></b-input>

                        </b-form>


                            <b-button class="mt-2" type="submit" variant="secondary">Submit</b-button>

                        </b-form>

<!--                <b-card-text>Header and footers using props.</b-card-text>-->
<!--                <b-button href="#" variant="primary">Go somewhere</b-button>-->
            </b-card>


<!--        <h1>wayfinder</h1>-->



<!--        <form @submit.prevent="submit">-->
<!--            <div>-->
<!--                <label for="email"></label>-->
<!--                <input type="text" name="email" id="email" v-model="form.email">-->
<!--            </div>-->

<!--            <div>-->
<!--                <label for="password"></label>-->
<!--                <input type="password" name="password" id="password" v-model="form.password">-->
<!--            </div>-->

<!--            <div>-->
<!--                <button type="submit">-->
<!--                    Sign in-->
<!--                </button>-->
<!--            </div>-->
<!--        </form>-->
    </div>
</template>

<style>

    .sign-in-container{
        display:flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
        align-items:center
    }

</style>

<script>

    import {mapActions} from 'vuex';

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
        components: {},
        methods: {
            ...mapActions({
                signIn: 'auth/signIn'
            }),
            submit() {
                this.signIn(this.form).then(() => {
                    this.$router.replace({
                        name: 'home'
                    })
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }

</script>