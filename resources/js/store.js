import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
Vue.config.debug = true;

export default new Vuex.Store({
    state: {
        user: {}
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
            window.localStorage.setItem("user", JSON.stringify(payload));
        },
        refreshUser(state) {
            axios
                .post(BASE_URL + "get-auth-user")
                .then(response => {
                    if (response.data) {
                        window.localStorage.setItem("user", JSON.stringify(response.data));
                        state.user = response.data;
                    } else {
                        window.localStorage.removeItem("user");
                        state.user = {};
                    }
                    state.initializeUser;
                })
                .catch(error => {
                    alert('Something went wrong');
                });

        },
        removeUser(state) {
            state.user = {};
            window.localStorage.removeItem("user");
        },
        initializeUser(state) {

            if (LOGGED_IN == 0) {
                this.commit("removeUser");
            }

            if (localStorage.getItem('user') && LOGGED_IN == true) {
                state.user = JSON.parse(window.localStorage.getItem("user"));
            } else {
                state.user = {};
            }
        }
    },
    actions: {

    },
    getters: {
        checkAuth() {
            if (localStorage.getItem('user')) {
                return true;
            } else {
                return false;
            }
        },
        getUser(state) {
            return state.user;
        }
    }
});