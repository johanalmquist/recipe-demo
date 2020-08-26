/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Admin from "./views/admin/Admin";
import VueProgressBar from 'vue-progressbar'


require('./bootstrap');

window.Vue = require('vue');
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '50px'
})

import Swal from 'sweetalert2'
window.swal = Swal


//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

import Vue from 'vue'
import {HasError, AlertError } from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
//Router Stuff
import VueRouter from 'vue-router'
Vue.use(VueRouter);
import App from './views/App'
import Home from './views/Home'
import Recipe from "./views/Recipe";
import Login from "./views/Login";
import ShowRecipe from "./views/admin/recipe/ShowRecipe";

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/recipe/:id',
            component: Recipe
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/admin',
            name: 'admin',
            component: Admin,
        },
        {
            path: '/admin/recipe/:id',
            name: 'admin.recipe',
            component: ShowRecipe
        }
    ],
});


const app = new Vue({
    el: '#app',
    components: { App },
    router,
});

