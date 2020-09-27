import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

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

// import { LMap, LTileLayer, LMarker, LIcon, LPopup, LTooltip, LControl, LControlLayers, LLayerGroup } from 'vue2-leaflet';
import 'leaflet-defaulticon-compatibility';
import 'leaflet/dist/leaflet.css';
// Vue.component('l-map', LMap);
// Vue.component('l-tile-layer', LTileLayer);
// Vue.component('l-marker', LMarker);
// Vue.component('l-icon', LIcon);
// Vue.component('l-popup', LPopup);
// Vue.component('l-tooltip', LTooltip);
// Vue.component('l-control', LControl);
// Vue.component('l-control-layers', LControlLayers);
// Vue.component('l-layer-group', LLayerGroup);

// import { Icon }  from 'leaflet'

// // this part resolve an issue where the markers would not appear
// delete Icon.Default.prototype._getIconUrl;

// Icon.Default.mergeOptions({
//     iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
//     iconUrl: require('leaflet/dist/images/marker-icon.png'),
//     shadowUrl: require('leaflet/dist/images/marker-shadow.png')
// });

// Vue.component('v-map', LMap);
// Vue.component('v-tilelayer', LTileLayer);
// Vue.component('v-marker', LMarker);


Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
