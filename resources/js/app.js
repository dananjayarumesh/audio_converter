/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// Vue.use(require('vue-resource'));

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'

import store from './store';

Vue.use(VueRouter)
Vue.use(Vuex)

import routes from './routes';
const router = new VueRouter({
    routes // short for `routes: routes`
})


Vue.component('app-header', require('./components/includes/AppHeader.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store
});
