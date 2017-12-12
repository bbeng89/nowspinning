import Vue from 'vue'
import router from './router'
import store from './store'

require('./bootstrap');

const app = new Vue({
    el: '#app',
    router,
    store
})
