// require("./bootstrap");

// require("vue2-admin-lte/src/lib/css");
// require("vue2-admin-lte/src/lib/script");
// import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';

// Require Froala Editor js file.
require('froala-editor/js/froala_editor.pkgd.min.js')

// Require Froala Editor css files.
require('froala-editor/css/froala_editor.pkgd.min.css')
require('froala-editor/css/froala_style.min.css')
import 'froala-editor/js/plugins.pkgd.min'

import '../sass/tailwind.css'

import VueRouter from "vue-router";
import Index from "./Index";
import router from "./routes";
import store from "./store";


import { VueperSlides, VueperSlide } from 'vueperslides'

import VueFroala from 'vue-froala-wysiwyg'
import VuePlyr from 'vue-plyr'
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
import draggable from 'vuedraggable'

import axios from "axios";

require('./store/subscriber');

//prodswap
axios.defaults.baseURL = 'https://evening-forest-04369.herokuapp.com/api/';
// axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';
// axios.defaults.baseURL = 'https://www.wayfinder.dev/api/';

import CKEditor from '@ckeditor/ckeditor5-vue/dist/ckeditor';

import { BootstrapVue, IconsPlugin, ModalPlugin } from 'bootstrap-vue'

// import vClickOutside from 'v-click-outside'
import Editor from 'ckeditor';
import Sortable from 'vue-sortable'


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
Vue.use(VueFroala)
Vue.use(VuePlyr)
Vue.use(VueBootstrapTypeahead)
// Vue.use(draggable)

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



