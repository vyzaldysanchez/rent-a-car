import LoginLayout from '../../components/Dashboard/Users/Layout/LoginLayout.vue'
import Login from '../../components/Dashboard/Users/Views/Login.vue'
import userService, {AUTH_USER_KEY} from '../../services/user.service'
import * as localforage from 'localforage'

export default {
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
                userService.logout().then(() => next({path: '/user/login'}));
            }
        }
    ]
};