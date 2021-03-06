import Vue from 'vue';
import VueRouter from 'vue-router';
import VueSweetAlert from 'vue-sweetalert';
import vClickOutside from 'v-click-outside';
// Plugins
import GlobalComponents from './globalComponents';
import Notifications from './components/UIComponents/NotificationPlugin';
import SideBar from './components/UIComponents/SidebarPlugin';
import LoadingMessage from './components/UIComponents/Messages';
import App from './App.vue';
import { AUTH_USER_KEY } from './services/user.service';
// router setup
import routes from './routes/routes';
// library imports
import * as localforage from 'localforage';
import Chartist from 'chartist';
import 'bootstrap/dist/css/bootstrap.css';
import './../sass/paper-dashboard.scss';
import 'es6-promise/auto';
import * as axios from 'axios';
import dataFormatter from './utils/data-formatter.utils';
import formsValidator from './utils/form-validator.utils';
import dateHelper from './utils/date.utils';

// plugin setup
Vue.use(VueRouter);
Vue.use(VueSweetAlert);
Vue.use(GlobalComponents);
Vue.use(vClickOutside);
Vue.use(Notifications);
Vue.use(SideBar);
Vue.use(LoadingMessage);

// Storage setup
localforage.default.config({
	name: 'vy-rent-car'
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
			next({ path: '/user/login' });
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

Object.defineProperty(Vue.prototype, '$formatter', {
	get() {
		return dataFormatter;
	}
});

Object.defineProperty(Vue.prototype, '$formsValidator', {
	get() {
		return formsValidator;
	}
});

Object.defineProperty(Vue.prototype, '$date', {
	get() {
		return dateHelper;
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
