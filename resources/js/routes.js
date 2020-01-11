let Main = require('./components/Main.vue').default
let Login = require('./components/Login.vue').default
let Register = require('./components/Register.vue').default
let History = require('./components/History.vue').default

export default [
{ path: '/', component: Main },
{ path: '/login', component: Login, meta: { auth: "guest" } },
{ path: '/register', component: Register, meta: { auth: "guest" } },
{ path: '/history', component: History, meta: { auth: "auth" } }
]