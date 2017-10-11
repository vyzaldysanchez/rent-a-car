import Sidebar from './SideBar.vue';

const SidebarStore = {
    showSidebar: false,
    sidebarLinks: [{
            name: 'Home',
            icon: 'ti-home',
            path: '/admin/profile'
        },
        {
            name: 'Vehicle Types',
            path: '/admin/vehicles/types'
        },
        {
            name: 'Brands',
            path: '/admin/vehicles/brands'
        },
        {
            name: 'Models',
            path: '/admin/vehicles/models'
        },
        {
            name: 'Fuels',
            path: '/admin/vehicles/fuels'
        },
        {
            name: 'logout',
            icon: 'ti-angle-double-left',
            path: '/user/logout'
        }
    ],
    displaySidebar(value) {
        this.showSidebar = value;
    }
};

const SidebarPlugin = {
    install(Vue) {
        Vue.mixin({
            data() {
                return { sidebarStore: SidebarStore };
            }
        });

        Object.defineProperty(Vue.prototype, '$sidebar', {
            get() {
                return this.$root.sidebarStore;
            }
        });

        Vue.component('side-bar', Sidebar);
    }
};

export default SidebarPlugin;