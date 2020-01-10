let Main = require('./components/Main.vue').default
let Login = require('./components/Login.vue').default
let Register = require('./components/Register.vue').default

export default [
    { path: '/', component: Main },
    { path: '/login', component: Login },
    { path: '/register', component: Register }
]