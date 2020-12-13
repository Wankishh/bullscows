require('./bootstrap');

window.Vue = require('vue');

import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'

Vue.use(VueMaterial);
Vue.component('game', require('./components/Game.vue').default);
const app = new Vue({
    el: '#app',
});
