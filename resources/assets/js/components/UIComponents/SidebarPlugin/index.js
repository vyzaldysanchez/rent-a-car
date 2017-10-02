import Sidebar from './SideBar.vue'

const SidebarStore = {
    showSidebar: false,
    sidebarLinks: [
        {
            name: 'Vehicle Types',
            icon: '',
            path: '/admin/vehicles/types'
        },
        {
            name: 'logout',
            icon: 'ti-angle-double-left',
            path: '/user/logout'
        }
    ],
    displaySidebar(value) {
        this.showSidebar = value
    }
};

const SidebarPlugin = {

    install(Vue) {
        Vue.mixin({
            data() {
                return {
                    sidebarStore: SidebarStore
                }
            }
        });

        Object.defineProperty(Vue.prototype, '$sidebar', {
            get() {
                return this.$root.sidebarStore
            }
        });

        Vue.component('side-bar', Sidebar)
    }
};

export default SidebarPlugin
