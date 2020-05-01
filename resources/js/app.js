require('./bootstrap');
import common from './common';
Vue.mixin(common);

import "babel-polyfill";

window.Vue = require('vue');
import Vue from 'vue'
import vuetify from './plugins/vuetify'


Vue.use(require('vue-moment'));

  router.afterEach((to, from) => {
    Vue.nextTick(() => {
        document.title = to.meta.title + '| Pizza ' ? to.meta.title : 'Pizza Title';
    });
})


Vue.component('z-dashboard', require('./components/dashboard.vue').default);


import router from './router'
import store from './store'

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store: store,
});
