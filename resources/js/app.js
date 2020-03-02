require("./bootstrap");

// require("vue2-admin-lte/src/lib/css");
// require("vue2-admin-lte/src/lib/script");
// import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';

import VueRouter from "vue-router";
import Index from "./Index";
import router from "./routes";
import store from "./store";

import { VueperSlides, VueperSlide } from 'vueperslides'

import axios from "axios";

require('./store/subscriber');

axios.defaults.baseURL = 'https://evening-forest-04369.herokuapp.com/api/';
// axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

import CKEditor from '@ckeditor/ckeditor5-vue/dist/ckeditor';

import { BootstrapVue, IconsPlugin, ModalPlugin } from 'bootstrap-vue'

// import vClickOutside from 'v-click-outside'
import Editor from 'ckeditor';


// Install BootstrapVue



window.Vue = require("vue");

Vue.use(VueRouter);
Vue.use( CKEditor );
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(ModalPlugin);
Vue.use(VueperSlides);
Vue.use(VueperSlide);
Vue.use(Editor);

const prod = process.env.NODE_ENV === 'production'
const shouldSW = 'serviceWorker' in navigator && prod
if (shouldSW) {
    navigator.serviceWorker.register('/service-worker.js').then(() => {
        console.log("Service Worker Registered!")
    })
}

store.dispatch('auth/attempt', localStorage.getItem('token')).then(() => {
    const app = new Vue({
        el: "#app",
        router,
        store,
        components: {
            index: Index
        },

    });
});



