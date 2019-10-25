require('./bootstrap');

import Vue from 'vue';

import '@mdi/font/css/materialdesignicons.css'
import Vuetify from 'vuetify';
import fr from 'vuetify/es5/locale/fr'
Vue.use(Vuetify);

import VueInstantSearch from 'vue-instantsearch';
Vue.use(VueInstantSearch);

import router from './router'
import store from './store'

import VueNumerals from 'vue-numerals'
Vue.use(VueNumerals, {
  locale: 'fr'
})


import Axios from 'axios'
Vue.use(Axios)

import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyDltHXvhv9M7PYZMJmX8cYvMoiqJv8gQ1E'
  },
})

import VuePapaParse from 'vue-papa-parse'
Vue.use(VuePapaParse)

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('navigation', require('./components/navigation.vue').default);

Vue.component('tableau-resultats', require('./components/TableauResultats.vue').default);
Vue.component('tableau-resultats-election', require('./components/TableauResultatsElection.vue').default);

Vue.component('analyse-toolbar', require('./components/AnalyseToolbar.vue').default);

Vue.component('finder', require('./components/forms/_Finder.vue').default);

const app = new Vue({
     data: () => ({
       drawer: true,
       menu: false
     }),
     created () {
       this.$vuetify.theme.dark = true
     },
     vuetify : new Vuetify({
       lang: {
          locales: {fr},
          current: 'fr'
        }
     }),
     router,
     store,
     el: '#app',
 });
