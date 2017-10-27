import DashboardLayout from '../components/Dashboard/Layout/DashboardLayout.vue';
// GeneralViews
import NotFound from '../components/GeneralViews/NotFoundPage.vue';
// Admin pages
import Overview from '../components/Dashboard/Views/Overview.vue';
import Employees from '../components/Dashboard/Management/Employees.vue';
import usersRoutes from './users/routes';
import vehiclesRoutes from './vehicles/routes';

const routes = [
    usersRoutes,
    {
        path: '/',
        component: DashboardLayout,
        redirect: '/admin'
    },
    {
        path: '/admin',
        component: DashboardLayout,
        redirect: '/admin/overview',
        children: [
            ...vehiclesRoutes,
            {
                path: 'overview',
                name: 'overview',
                component: Overview
            },
            {
                path: 'employees',
                name: 'employees',
                component: Employees
            },
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
