import Vue from 'vue';
import Vuetify from '../plugins/vuetify';
import App from './App.vue';
import router from './router';
import VueSweetalert2 from 'vue-sweetalert2';
import Vuelidate from 'vuelidate';
import 'sweetalert2/dist/sweetalert2.min.css';
import store from './store';

Vue.use(Vuetify);   
Vue.use(Vuelidate);
Vue.use(VueSweetalert2);

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    router,
    store,
    render: h => h(App),
});