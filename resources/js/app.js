 require('./bootstrap');
 window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'

import store from './store';

Vue.use(VueRouter)
Vue.use(Vuex)

import routes from './routes';
const router = new VueRouter({
	mode: 'history',
    routes // short for `routes: routes`
})

router.beforeEach((to, from, next) => {

	if (to.meta.auth == "auth") {
		if (window.localStorage.getItem('user')) {
			next();
		} else {
			next({ path: '/login' });
		}
	} else if (to.meta.auth == "guest") {
		if (window.localStorage.getItem('user')) {
			next({ path: '/' });
		} else {
			next();
		}
	}
	next();
})

Vue.component('app-header', require('./components/includes/AppHeader.vue').default);

const app = new Vue({
	el: '#app',
	router,
	store, 
	beforeMount() {
		this.$store.commit('initializeUser');
	},
	data() {
		return {
			loggedIn : (LOGGED_IN == 1)?true:false
		};
	},
	watch: {
		user: function(newVal, oldVal) {
			if (newVal.id) {
				this.loggedIn = true;
			} else {
				this.loggedIn = false;
			}
		}
	},
	computed: {
		user() {
			return this.$store.state.user;
		}
	}
});
