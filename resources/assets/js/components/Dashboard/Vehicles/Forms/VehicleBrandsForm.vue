<template>
    <div class="vehicle-brands-form">
        <form>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <fg-input label="Description" placeholder="Description..." :required="true" v-model="description">
                    </fg-input>

                    <div class="text-center">
                        <button class="btn btn-info btn-fill btn-wd" :class="{'disabled': isSavingBrand}"
                                @click.prevent="validBeforeSave">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <notifications>

        </notifications>
    </div>
</template>
<script>
    import PaperNotification from '../../../UIComponents/NotificationPlugin/Notification.vue'

    export default {
        components: {
            PaperNotification
        },
        props: {
            edit: Boolean,
            brand: Object
        },
        watch: {
            brand(newValue) {
                this.description = newValue ? newValue.description : '';
            }
        },
        data() {
            return {
                description: this.$props.brand ? this.$props.brand.description : '',
                isSavingBrand: false
            };
        },
        methods: {
            isFormValid() {
                return !!this.description;
            },
            validBeforeSave() {
                if (this.isFormValid()) {
                    const actionToPerform = this.edit ? 'updated' : 'created';
                    this.$swal({
                        title: 'Are you sure?',
                        html: `The vehicle brand <b>${this.description}</b> will be ${actionToPerform}.`,
                        type: 'warning',
                        showConfirmButton: true,
                        showCancelButton: true
                    }).then(this.save.bind(this));
                } else {
                    this.notifyInvalidForm();
                }
            },
            save() {
                const body = {description: this.description},
                    actionPerformed = this.edit ?
                        this.getUpdatePromise(body) :
                        this.getCreatePromise(body);

                this.isSavingBrand = true;

                actionPerformed.then(res => {
                    const actionToNotify = this.edit ? 'brand-updated' : 'brand-created';
                    this.description = '';
                    this.isSavingBrand = false;
                    this.$emit(actionToNotify, res.data);
                });
            },
            getCreatePromise(body) {
                return this.$axios.post(`http://localhost:8000/api/brands`, body);
            },
            getUpdatePromise(body) {
                return this.$axios.put(`http://localhost:8000/api/brands/${this.$props.brand.id}`, body);
            },
            notifyInvalidForm() {
                this.$notifications.notify({
                    message: 'The description field is empty.',
                    type: 'danger',
                    verticalAlign: 'bottom',
                    horizontalAlign: 'right',
                    icon: 'fa fa-warning'
                });
            }
        }
    };
</script>