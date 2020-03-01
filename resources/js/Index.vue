<template  >

    <div class="index" >
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
        <Nav></Nav>

<!--        <div class="container-fluid index-container">-->
<!--            <div class="row" style="width: inherit">-->

<!--                <div class="col-xs-2">-->
<!--                    <Sidebar class="sidebar"></Sidebar>-->
<!--                </div>-->
<!--                <div class="router-view col-xs-10">-->
<!--                    <router-view></router-view>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <b-container fluid v-if="authenticated">
            <b-row>
                <b-col cols="12" class="router-view" >
                    <router-view></router-view>
                </b-col>
            </b-row>
        </b-container>

        <b-container fluid v-if="!authenticated">
            <b-row>
                <b-col cols="12">
                    <router-view></router-view>
                </b-col>
            </b-row>
        </b-container>



    </div>

</template>


<script>

    import Nav from './Nav';
    import VAButton from 'vue2-admin-lte/src/components/VAButton.vue'
    import Sidebar from './Sidebar';
    import { mapGetters } from 'vuex';

    export default {

        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user'
            })
        },

        components: {
            Nav,
            Sidebar,
            'va-button': VAButton
        },
    }

</script>

