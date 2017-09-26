import Vue from 'vue'
import VueRouter from 'vue-router'
import vClickOutside from 'v-click-outside'
// Plugins
import GlobalComponents from './globalComponents'
import Notifications from './components/UIComponents/NotificationPlugin'
import SideBar from './components/UIComponents/SidebarPlugin'
import App from './App.vue'
import {AUTH_USER_KEY} from './services/user.service'
// router setup
import routes from './routes/routes'
// library imports
import * as localforage from 'localforage'
import Chartist from 'chartist'
import 'bootstrap/dist/css/bootstrap.css'
import './../sass/paper-dashboard.scss'
import 'es6-promise/auto'
import * as axios from 'axios'

// plugin setup
Vue.use(VueRouter);
Vue.use(GlobalComponents);
Vue.use(vClickOutside);
Vue.use(Notifications);
Vue.use(SideBar);

// Storage setup
localforage.config({
    name: 'vy-rent-car',
});

// configure router
const router = new VueRouter({
    routes, // short for routes: routes
    linkActiveClass: 'active'
});

router.beforeEach((to, from, next) => {
    localforage.getItem(AUTH_USER_KEY).then(user => {
        if (user || to.fullPath === '/user/login') {
            next();
        } else {
            next({path: '/user/login'});
        }
    });
});

// global library setup
Object.defineProperty(Vue.prototype, '$Chartist', {
    get() {
        return this.$root.Chartist;
    }
});

Object.defineProperty(Vue.prototype, '$storage', {
    get() {
        return localforage;
    }
});

Object.defineProperty(Vue.prototype, '$axios', {
    get() {
        return axios;
    }
});

/* eslint-disable no-new */
new Vue({
    el: '#app',
    render: h => h(App),
    router,
    data: {
        Chartist
    }
});