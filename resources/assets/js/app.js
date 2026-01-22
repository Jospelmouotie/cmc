
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

import { createApp } from 'vue';

// import InstantSearch from 'vue-instantsearch';
// Vue.use(InstantSearch);

import ExampleComponent from './components/ExampleComponent.vue';
// Vue.component('example-component', ExampleComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = createApp({});

// Enregistrez les composants
app.component('example-component', ExampleComponent);

// Montez l'application
app.mount('#app');



