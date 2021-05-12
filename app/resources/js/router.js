import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Dashboard from "./components/Home/Dashboard.vue";

import OnboardAggregatorFirst from "./components/Aggregator/OnboardFirst.vue";
import OnboardAggregatorSecond from "./components/Aggregator/OnboardSecond.vue";

import WakalaContract from "./components/Wakala/Contract.vue";
import OnboardWakalaFirst from "./components/Wakala/OnboardFirst.vue";
import OnboardWakalaSecond from "./components/Wakala/OnboardSecond.vue";

import ViewAllAggregators from "./components/Aggregator/ViewAll.vue";
import ViewAllWakala from "./components/Wakala/ViewAll.vue";

import OnboardWakalaRecruiter from "./components/Wakala/OnboardRecruiter.vue";
import ViewAllRecruiter from "./components/Wakala/Recruiter.vue";

import ViewUnverifiedWakala from "./components/Wakala/UnverifiedWakala.vue";

import ViewSingleUnverifiedWakala from "./components/Wakala/ViewSingleUnverifiedWakala.vue";

import ViewApprovedWakala from "./components/Wakala/ApprovedWakala.vue";

import ViewDeclinedWakala from "./components/Wakala/DeclinedWakala.vue";

import ViewWakalaWithStatus from "./components/Wakala/WakalaStatus.vue";

import Reports from "./components/Reports/Reports.vue";

var isAuthenticated = false;

function guardMyroute(to, from, next) {
    for (let i = 0; i < localStorage.length; i++) {
        let key = localStorage.key(i);
        let value = localStorage.getItem(key);
        console.log(key, value);
    }

    const user = JSON.parse(sessionStorage.getItem("user"));
    if (user.status === true) isAuthenticated = true;
    else isAuthenticated = false;

    if (isAuthenticated) {
        next();
    } else {
        sessionStorage.clear();
        next("/login");
    }
}

export default new VueRouter({
    routes: [
        // { path: "/", name: "login", component: LoginForm },
        // { path: "/login", name: "login2", component: LoginForm },
        // { path: "/otp", name: "otp", component: OTPForm },
        // {
        //     path: "/forgot-password",
        //     name: "forgot-password",
        //     component: ForgotPasswordForm
        // },
        // {
        //     path: "/recover-password",
        //     name: "recover-password",
        //     component: RecoverPasswordForm
        // },
        {
            path: "/home",
            name: "home",
            component: Dashboard
            //beforeEnter: guardMyroute
        },
        {
            path: "/aggregator/onboard-nida",
            name: "onboard-aggregator-nida",
            component: OnboardAggregatorFirst
            //beforeEnter: guardMyroute
        },
        {
            path: "/aggregator/onboard-save",
            name: "onboard-aggregator-save",
            component: OnboardAggregatorSecond
            //beforeEnter: guardMyroute
        },
        {
            path: "/aggregator/all",
            name: "view-aggregator-all",
            component: ViewAllAggregators
            //beforeEnter: guardMyroute
        },
        {
            path: "/wakala/onboard-contract",
            name: "onboard-wakala-contract",
            component: WakalaContract
            //beforeEnter: guardMyroute
        },
        {
            path: "/wakala/onboard-nida",
            name: "onboard-wakala-nida",
            component: OnboardWakalaFirst
            //beforeEnter: guardMyroute
        },
        {
            path: "/wakala/onboard-save",
            name: "onboard-wakala-save",
            component: OnboardWakalaSecond
            //beforeEnter: guardMyroute
        },
        {
            path: "/wakala/all",
            name: "view-wakala-all",
            component: ViewAllWakala
            //beforeEnter: guardMyroute
        },
        {
            path: "/recruiter/all",
            name: "view-recruiter-all",
            component: ViewAllRecruiter
            // beforeEnter: guardMyroute
        },
        {
            path: "/recruiter/onboard",
            name: "onboard-wakala-recruiter",
            component: OnboardWakalaRecruiter
            // beforeEnter: guardMyroute
        },
        {
            path: "/wakala/unverified",
            name: "view-wakala-unverified",
            component: ViewUnverifiedWakala
            // beforeEnter: guardMyroute
        },
        {
            path: "/wakala/single/unverified",
            name: "view-wakala-single-unverified",
            component: ViewSingleUnverifiedWakala
            // beforeEnter: guardMyroute
        },
        {
            path: "/wakala/approved",
            name: "view-wakala-approved",
            component: ViewApprovedWakala
            //beforeEnter: guardMyroute
        },
        {
            path: "/wakala/declined",
            name: "view-wakala-declined",
            component: ViewDeclinedWakala
            //beforeEnter: guardMyroute
        },
        {
            path: "/wakala/status",
            name: "view-wakala-status",
            component: ViewWakalaWithStatus
            //beforeEnter: guardMyroute
        },
        {
            path: "/reports",
            name: "view-reports",
            component: Reports
            //beforeEnter: guardMyroute
        }
    ],
    mode: "history"
});
