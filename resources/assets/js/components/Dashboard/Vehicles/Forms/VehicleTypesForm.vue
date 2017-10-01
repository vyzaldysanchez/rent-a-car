<template>
    <div class="vehicle-types-form">
        <form>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <fg-input label="Description" placeholder="description" :required="true"
                              v-model="description"></fg-input>

                    <div class="text-center">
                        <button class="btn btn-info btn-fill btn-wd"
                                :class="{'disabled': isSavingVehicleType}"
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
        data() {
            return {
                isSavingVehicleType: false,
                description: ''
            };
        },
        methods: {
            isFormValid() {
                return !!this.description;
            },
            save() {
                if (this.isFormValid()) {
                    this.isSavingVehicleType = true;

                    this.$axios.post('http://localhost:8000/api/types', {description: this.description})
                        .then(res => {
                            this.description = '';
                            this.isSavingVehicleType = false;

                            this.$emit('type-created', res.data);
                        });
                } else {
                    this.$notifications.notify({
                        message: 'The description field is empty.',
                        type: 'danger',
                        verticalAlign: 'bottom',
                        horizontalAlign: 'right',
                        icon: 'fa fa-warning'
                    });
                }
            }
        }
    };
</script>
<style></style>