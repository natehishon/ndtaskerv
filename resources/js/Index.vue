<template>

    <div>
        <Nav></Nav>
<!--        <nav class="navbar bg-white border-bottom navbar-light">-->
<!--            <router-link class="nav-brand mr-auto" :to="{name: 'home'}">Home</router-link>-->
<!--            <router-link class="btn nav-button" :to="{name: 'signin'}">Sign In</router-link>-->
<!--&lt;!&ndash;            <router-link class="btn nav-button" :to="{name: 'second'}">Second</router-link>&ndash;&gt;-->
<!--        </nav>-->

        <div class="container mt-4 mb-4 pr-4 pl-4">
            <router-view></router-view>
        </div>

    </div>

</template>


<script>

    import Nav from './Nav';

    export default {

        components: {
            Nav
        },
    }

</script>

