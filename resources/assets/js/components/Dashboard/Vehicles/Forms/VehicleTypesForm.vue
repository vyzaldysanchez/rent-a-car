<template>
    <div class="vehicle-types-form">
        <form>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <fg-input label="Description" placeholder="Description..." :required="true" v-model="description">
                    </fg-input>

                    <div class="text-center">
                        <button class="btn btn-info btn-fill btn-wd" :class="{'disabled': isSavingVehicleType}"
                                @click.prevent="save">
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
            vehicleType: Object
        },
        watch: {
            vehicleType(newValue) {
                this.description = newValue ? newValue.description : '';
            }
        },
        data() {
            return {
                isSavingVehicleType: false,
                description: this.$props.vehicleType ? this.$props.vehicleType.description : ''
            };
        },
        methods: {
            isFormValid() {
                return !!this.description;
            },
            save() {
                if (this.isFormValid()) {
                    const vehicleType = {description: this.description},
                        actionPerformed = this.edit ?
                            this.getUpdatePromise(vehicleType) :
                            this.getCreatePromise({description: this.description});

                    this.isSavingVehicleType = true;

                    actionPerformed.then(res => {
                        const actionToNotify = this.edit ? 'type-updated' : 'type-created';
                        this.description = '';
                        this.isSavingVehicleType = false;
                        this.$emit(actionToNotify, res.data);
                    });
                } else {
                    this.notifyInvalidForm();
                }
            },
            getCreatePromise(body) {
                return this.$axios.post(`http://localhost:8000/api/types`, body);
            },
            getUpdatePromise(body) {
                return this.$axios.put(`http://localhost:8000/api/types/${this.$props.vehicleType.id}`, body);
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
<style></style>