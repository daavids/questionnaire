import Vue from 'vue';
import Auth from './components/Auth.vue';
import TestChoice from './components/TestChoice.vue';

window.$ = window.jQuery = require('jquery');
require('popper.js');
require('bootstrap');

Vue.prototype.$http = require('axios');

document.addEventListener('DOMContentLoaded', () => {
    let app = new Vue({
        el: '#app',
        components: {
            'auth-component': Auth,
            'test-choice-component': TestChoice
        }
    });
});