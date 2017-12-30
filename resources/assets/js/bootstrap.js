import Vue from 'vue'
import VueResource from 'vue-resource'
import InfiniteScroll from 'vue-infinite-scroll'

window.$ = window.jQuery = require('jquery');
window._ = require('lodash');
window.Vue = require('vue');
window.axios = require('axios');

require('bootstrap-sass');

Vue.use(VueResource);
Vue.use(InfiniteScroll);

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    Vue.http.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.http.headers.common['X-Requested-With'] = 'XMLHttpRequest';
