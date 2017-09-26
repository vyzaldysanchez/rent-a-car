import DashboardLayout from '../components/Dashboard/Layout/DashboardLayout.vue'
import LoginLayout from '../components/Users/Layout/LoginLayout.vue'
// GeneralViews
import NotFound from '../components/GeneralViews/NotFoundPage.vue'
// Admin pages
import Overview from '../components/Dashboard/Views/Overview.vue'
import UserProfile from '../components/Dashboard/Views/UserProfile.vue'
import Notifications from '../components/Dashboard/Views/Notifications.vue'
import Icons from '../components/Dashboard/Views/Icons.vue'
import Maps from '../components/Dashboard/Views/Maps.vue'
import Typography from '../components/Dashboard/Views/Typography.vue'
import TableList from '../components/Dashboard/Views/TableList.vue'
import Login from '../components/Users/Views/Login.vue'
import localforage from 'localforage'
import userService, {AUTH_USER_KEY} from '../services/user.service'

const routes = [
    {
        path: '/user',
        component: LoginLayout,
        children: [
            {
                path: 'login',
                name: 'login',
                component: Login,
                beforeEnter: (to, from, next) => {
                    localforage.getItem(AUTH_USER_KEY).then(user => {
                        if (user) {
                            next({path: '/admin/overview'});
                        } else {
                            next();
                        }
                    });
                }
            },
            {
                path: 'logout',
                name: 'logout',
                beforeEnter: (to, from, next) => {
                    userService.logout()
                        .then(() => next({path: '/user/login'}));
                }
            }
        ]
    },
    {
        path: '/',
        component: DashboardLayout,
        redirect: '/admin/overview'
    },
    {
        path: '/admin',
        component: DashboardLayout,
        redirect: '/admin/stats',
        children: [
            {
                path: 'overview',
                name: 'overview',
                component: Overview
            },
            {
                path: 'stats',
                name: 'stats',
                component: UserProfile
            },
            {
                path: 'notifications',
                name: 'notifications',
                component: Notifications
            },
            {
                path: 'icons',
                name: 'icons',
                component: Icons
            },
            {
                path: 'maps',
                name: 'maps',
                component: Maps
            },
            {
                path: 'typography',
                name: 'typography',
                component: Typography
            },
            {
                path: 'table-list',
                name: 'table-list',
                component: TableList
            }
        ]
    },
    {path: '*', component: NotFound}
];

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
 function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes;
