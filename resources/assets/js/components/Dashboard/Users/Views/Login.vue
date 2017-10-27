<template>
    <div class="login">
        <div class="col-md-6 col-md-offset-3">
            <div class="header">
                <h2><i class="ti-car"></i> {{title}}</h2>
                <h3>{{subtitle}}</h3>
            </div>

            <form>
                <div class="row">
                    <div class="col-md-12">
                        <fg-input type="email" label="Username" placeholder="employee" v-model="email">
                        </fg-input>
                    </div>
                    <div class="col-md-12">
                        <fg-input type="password" label="Password" placesholder="******" v-model="password"></fg-input>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-info btn-fill btn-wd"
                                :class="{'disabled': authenticating}"
                                @click.prevent="login">Login
                        </button>
                    </div>
                    <notifications>

                    </notifications>
                </div>
            </form>
        </div>
    </div>
</template>
<style scoped lang="scss">
    .login {
        display: flex;
        flex-flow: column;
        margin-top: 10%;

        .header {
            text-align: center;
        }
    }
</style>
<script>
    import PaperNotification from '../../../UIComponents/NotificationPlugin/Notification.vue'
    import userService from '../../../../services/user.service';

    const LOGIN_TEXT = 'Login',
        LOADING_TEXT = 'Loading...';

    export default {
        components: {
            PaperNotification
        },
        data() {
            return {
                authenticating: false,
                email: null,
                password: null,
                title: 'Welcome to Rent-cart',
                subtitle: 'Please, login!',
                loginBtnText: LOGIN_TEXT
            };
        },
        methods: {
            login() {
                if (this.isFormValid()) {
                    const user = {email: this.email, password: this.password};
                    this.authenticating = true;
                    this.loginBtnText = LOADING_TEXT;

                    userService.login(user).then(() => this.$router.push({path: '/'}))
                        .catch(error => {
                            this.authenticating = false;
                            this.loginBtnText = LOGIN_TEXT;

                            if (error.response.status === 422) {
                                const errors = error.response.data.errors;
                                if (errors) {
                                    const errorKeys = Object.keys(errors);
                                    this.alertError(errors[errorKeys[0]][0] || 'Credentials invalid. Try again.');
                                } else {
                                    this.alertError('Credentials invalid. Try again.');
                                }
                            }
                        });
                } else {
                    this.alertError('Some credentials are empty, check and try again.');
                }
            },
            isFormValid() {
                return this.email && this.password;
            },
            alertError(message = '') {
                this.$notifications.notify({
                    message: message,
                    type: 'danger',
                    verticalAlign: 'bottom',
                    horizontalAlign: 'right',
                    icon: 'fa fa-warning'
                });
            }
        }
    };
</script>