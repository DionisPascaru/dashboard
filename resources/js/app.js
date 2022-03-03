/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
Vue.component('app', require('./App').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue';
import ElementUi from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import router from './router';
import store from './store';

Vue.use(VueRouter);
Vue.use(ElementUi, locale);
Vue.use(Vuex);

const app = new Vue({
    el: '#app',
    router,
    store
});
