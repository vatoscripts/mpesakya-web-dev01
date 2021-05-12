/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";

import router from "./router";

import VueProgressBar from "vue-progressbar";

// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

Vue.use(Loading);

Vue.use(VueProgressBar, {
    color: "#0cb23f",
    failedColor: "#df0b0b",
    thickness: "3px",
    transition: {
        speed: "0.005s",
        opacity: "0.1s",
        termination: 300
    }
});

import Swal from "sweetalert2";
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000
});

window.Toast = Toast;

require("./bootstrap");

require("typeface-nunito");

/* Register our new component: */
Vue.component("login-form", require("./components/Auth/Login.vue").default);
Vue.component("otp-form", require("./components/Auth/Otp.vue").default);
Vue.component(
    "reset-password-form",
    require("./components/Auth/ResetPassword.vue").default
);
Vue.component(
    "recover-password-form",
    require("./components/Auth/RecoverPassword.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    router
});
