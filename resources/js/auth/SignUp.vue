<template>

    <div class="sign-in-container">

        <b-card class="mt-5"
                header="sign up"
                header-tag="header"
                header-class="login-header"
        >

            <b-form class="way-form" @submit.prevent="submit">
                <b-form-group
                    id="input-group-1"
                    label="email address:"
                    label-for="input-1"
                    description=""
                >
                    <b-form-input
                        id="input-1"
                        v-model="form.email"
                        type="email"
                        required
                        placeholder="enter email"
                    ></b-form-input>
                </b-form-group>

                <b-form-group
                    id="input-group-2"
                    label="name:"
                    label-for="input-2"
                    description=""
                >
                    <b-form-input
                        id="input-2"
                        v-model="form.name"
                        type="text"
                        required
                        placeholder="enter name"
                    ></b-form-input>
                </b-form-group>

                <b-form-group>
                    <label for="text-password">password</label>
                    <b-input type="password" placeholder="enter password" id="text-password" v-model="form.password" aria-describedby="password-help-block"></b-input>
                </b-form-group>

                <div class="sign-in-buttons">
                <b-button size="lg" type="submit" class="mb-3 mr-2  " variant="success">
                    submit&nbsp;&nbsp;<i class="fas fa-user-plus"></i>
                </b-button>
                <b-button size="lg" @click="signInButton" class="mb-3" variant="info">
                    sign in&nbsp;&nbsp;<i class="fas fa-door-open"></i>
                </b-button>
                </div>

            </b-form>

        </b-card>

    </div>
</template>

<style lang="scss">

    /*.sign-in-buttons{*/
    /*    display: flex;*/
    /*    flex-direction: row;*/
    /*    justify-content: flex-end;*/
    /*}*/

    .sign-up-container{
        display:flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
        align-items:center
    }

</style>

<script>

    import {mapActions} from 'vuex';
    import axios from "axios";

    export default {
        name: 'signup',
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
                axios.post('users', this.form).then(response => {

                    this.signIn(this.form).then(() => {
                        this.$router.replace({
                            name: 'home'
                        })
                    }).catch(err => {
                        console.log(err);
                    });

                }).catch(err => {
                    //throw error
                    console.log(err);
                });
            },
            signInButton(){
                this.$router.replace({
                    name: 'signin'
                })
            }
        }
    }

</script>
