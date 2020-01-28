<template>

    <div class="index">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
        <Nav></Nav>

        <div class="container-fluid index-container">
            <div class="row" style="width: 100%">

                <Sidebar class="col-xs-2 sidebar"></Sidebar>
                <div class="router-view col-xs-10">
                    <router-view ></router-view>
                </div>

            </div>



        </div>




    </div>

</template>


<script>

    import Nav from './Nav';
    import VAButton from 'vue2-admin-lte/src/components/VAButton.vue'
    import Sidebar from './Sidebar';

    export default {

        components: {
            Nav,
            Sidebar,
            'va-button': VAButton
        },
    }

</script>

