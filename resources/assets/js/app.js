import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var router = new VueRouter({
    mode: 'history',
    routes: routes
})

var app = new Vue({
    el: '#app',
    router: router
})
