import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Axios from 'axios'

import VueSessionStorage from 'vue-sessionstorage'
Vue.use(VueSessionStorage)

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import 'bootstrap-css-only/css/bootstrap.min.css'
import '@fortawesome/fontawesome-free/css/all.min.css'

import 'leaflet-defaulticon-compatibility';
import 'leaflet/dist/leaflet.css';

Axios.defaults.headers.common['Authorization'] = 'AUTH_TOKEN';

Axios.interceptors.request.use(
  config => {
      const token = 'localStorage.getItem';
      if (token) {
          config.headers['Authorization'] = 'Bearer ' + token;
      }
      // config.headers['Content-Type'] = 'application/json';
      return config;
  },
  error => {
      Promise.reject(error)
});

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
