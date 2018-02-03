import Vue from 'vue'
import VueResource from 'vue-resource'
import InfiniteScroll from 'vue-infinite-scroll'
import VeeValidate from 'vee-validate';
import Meta from 'vue-meta';
import Notifications from 'vue-notification';
import EventBus from './helpers/eventbus';

window.$ = window.jQuery = require('jquery');
window._ = require('lodash');
window.Vue = require('vue');
window.axios = require('axios');
window.moment = require('moment');
window.EventBus = new EventBus();

require('bootstrap-sass');

// https://github.com/pagekit/vue-resource
Vue.use(VueResource);
// https://github.com/ElemeFE/vue-infinite-scroll
Vue.use(InfiniteScroll);
// https://github.com/baianat/vee-validate
Vue.use(VeeValidate);
// https://github.com/declandewet/vue-meta
Vue.use(Meta);
// https://github.com/euvl/vue-notification
Vue.use(Notifications);

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    Vue.http.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.http.headers.common['X-Requested-With'] = 'XMLHttpRequest';
