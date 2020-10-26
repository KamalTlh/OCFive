import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Axios from 'axios'

import VueSessionStorage from 'vue-sessionstorage'
Vue.use(VueSessionStorage)

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

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

// Add a request interceptor
Axios.interceptors.request.use(function (config) {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers['Authorization'] = 'Bearer ' + token;
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});

// Add a response interceptor
Axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
  if(error.response.status == 401){
    store.commit("changeSessionState", false );
    store.commit("setUserLogged", null );
    store.commit("changeUser", null );
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    router.push({ path: '/login' });
  }
  else if(error.response.status == 500){
    router.push({ path: '/error500' });
  }
  return Promise.reject(error);
});

Vue.config.productionTip = false

// new Vue({
//   router,
//   store,
//   render: h => h(App)
// }).$mount('#app')

new Vue({
  router,
  store,
  el: '#app',
  render(h) { return h(App) }
})
