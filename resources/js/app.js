require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    { path: '/About', component: require('./components/About.vue').default },
    { path: '/Dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/Customer', component: require('./components/Customer.vue').default },
    { path: '/addCustomer', component: require('./components/addCustomer.vue').default }
]

const router = new VueRouter({
    routes // short for `routes: routes`
})

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});