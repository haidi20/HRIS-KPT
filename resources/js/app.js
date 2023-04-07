window.Vue = require("vue").default;
import store from "./stores/main";

import Vue from "vue";

import BootstrapVue from "bootstrap-vue";
import VueSweetalert2 from "vue-sweetalert2";
import VueExcelEditor from "vue-excel-editor";
import VueEvents from "vue-events";
import { ServerTable, ClientTable, Event } from "vue-tables-2";
// import clickOutside from './vue-directive-clickOutside';

import "vue-select/dist/vue-select.css";
import "sweetalert2/dist/sweetalert2.min.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("dashboard", require("./modules/dashboard/Dashboard.vue").default);

// Vue.directive('click-outside', clickOutside);
Vue.config.productionTip = false;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.use(VueEvents);
Vue.use(BootstrapVue);
Vue.use(VueExcelEditor);
Vue.use(VueSweetalert2);
Vue.use(ServerTable);
Vue.use(ClientTable);

new Vue({
    store,
    el: "#root",
});
