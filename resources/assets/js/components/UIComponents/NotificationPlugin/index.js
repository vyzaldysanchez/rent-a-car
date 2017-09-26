import Notifications from './Notifications.vue'

const NotificationStore = {
    state: [], // here the notifications will be added

    removeNotification(index) {
        this.state.splice(index, 1)
    },
    notify(notification) {
        this.state.push(notification)
    }
};

const NotificationsPlugin = {
    install(Vue) {
        Object.defineProperty(Vue.prototype, '$notifications', {
            get() {
                return NotificationStore
            }
        });

        Vue.component('Notifications', Notifications)
    }
};

export default NotificationsPlugin
