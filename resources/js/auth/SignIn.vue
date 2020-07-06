<template>

    <div class="sign-in-container">

        <b-card class="mt-5"
                header="sign in"
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

                <b-form-group>
                    <label for="text-password">password</label>
                    <b-input type="password" placeholder="enter password" id="text-password" v-model="form.password"
                             aria-describedby="password-help-block"></b-input>
                </b-form-group>

                <div class="sign-in-buttons">
                    <b-button size="lg" type="submit" class="mb-3 mr-2" variant="success">
                        sign in&nbsp;&nbsp;<i class="fas fa-door-open"></i>
                    </b-button>
                    <b-button size="lg" @click="signUp" class="mb-3" variant="info">
                        sign up&nbsp;&nbsp;<i class="fas fa-user-plus"></i>
                    </b-button>
                </div>


            </b-form>

        </b-card>

    </div>
</template>

<style lang="scss">

    .sign-in-container {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center
    }

    .sign-in-buttons{
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
    }

    .login-header {
        font-size: 1.5rem;
        font-weight: 600;
        color: #495057;
        text-align: center;
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
            },
            signUp() {
                this.$router.replace({
                    name: 'signUp'
                })
            }
        }
    }

</script>
