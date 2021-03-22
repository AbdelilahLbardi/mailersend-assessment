import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap')

Vue.use(VueRouter)

import App from './Views/Application'
import Home from './Views/Home'
import Mail from './Views/Mail'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/mail/:id',
            name: 'mail',
            component: Mail,
        },
        {
            path: '/',
            name: 'home',
            component: Home
        },
    ],
});


const app = new Vue({
    el: '#app',
    components: { App, Home, Mail },
    router,
});