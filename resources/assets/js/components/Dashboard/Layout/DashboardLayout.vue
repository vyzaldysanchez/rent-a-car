<template>
    <div class="wrapper">
        <side-bar type="sidebar" :sidebar-links="$sidebar.sidebarLinks" :userName="userName">

        </side-bar>
        <notifications>

        </notifications>
        <div class="main-panel">
            <top-navbar></top-navbar>

            <dashboard-content @click.native="toggleSidebar">

            </dashboard-content>

            <content-footer></content-footer>
        </div>
    </div>
</template>
<style lang="scss">

</style>
<script>
    import TopNavbar from './TopNavbar.vue'
    import ContentFooter from './ContentFooter.vue'
    import DashboardContent from './Content.vue'
    import {AUTH_USER_KEY} from '../../../services/user.service'

    export default {
        components: {
            TopNavbar,
            ContentFooter,
            DashboardContent
        },
        data() {
            return {
                userName: ''
            };
        },
        methods: {
            toggleSidebar() {
                if (this.$sidebar.showSidebar) {
                    this.$sidebar.displaySidebar(false)
                }
            }
        },
        mounted() {
            this.$storage.getItem(AUTH_USER_KEY)
                .then(user => this.userName = user.name);
        }
    }

</script>
