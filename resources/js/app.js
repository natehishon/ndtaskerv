require("./bootstrap");

require("vue2-admin-lte/src/lib/css");
require("vue2-admin-lte/src/lib/script");

import VueRouter from "vue-router";
import Index from "./Index";
import router from "./routes";
import store from "./store";

import axios from "axios";

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/'



window.Vue = require("vue");
Vue.use(VueRouter);





const app = new Vue({
    el: "#app",
    router,
    components: {
        index: Index
    },

});