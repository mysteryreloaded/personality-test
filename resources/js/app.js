/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'
import Page from "./components/Page";
import Welcome from "./components/Welcome";
import Questions from "./components/Questions";

const routes = [
    { path: '/questions/:id', component: Questions},
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes, // short for `routes: routes`
});

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(router);
app.component('page', Page);app.component('page', Page);
app.component('welcome', Welcome);app.component('welcome', Welcome);
app.component('questions', Questions);app.component('questions', Questions);

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
