require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';
import moment from 'moment';

Vue.use(VueRouter);
Vue.use(VeeValidate);

Vue.component('app-nav', require('./components/AppNav.vue'));
Vue.component('log-form', require('./components/LogForm.vue'));
Vue.component('occupancy-table', require('./components/OccupancyTable.vue'));

const routes = [
    { path: '/', component: require('./pages/Log.vue') },
    { path: '/statistics', component: require('./pages/Statistics.vue') }
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});


const app = new Vue({
    router: router,
}).$mount('#app');
