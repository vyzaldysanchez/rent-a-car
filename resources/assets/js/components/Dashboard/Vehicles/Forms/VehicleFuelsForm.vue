<template>
    <div class="vehicles-fuels-form">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <fg-input label="Description" placeholder="Fuel description..." :required="true"
                          v-model="description"></fg-input>

                <div class="text-center">
                    <button class="btn btn-info btn-fill btn-wd" :class="{'disabled': isSavingFuel}"
                            @click.prevent="validBeforeSave">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <notifications></notifications>
    </div>
</template>
<script>
    import PaperNotification from './../../../UIComponents/NotificationPlugin/Notification.vue';

    export default {
        components: {
            PaperNotification
        },
        props: {
            edit: Boolean,
            fuel: Object
        },
        watch: {
            fuel(newFuel) {
                this.description = newFuel ? newFuel.description : '';
            }
        },
        data() {
            return {
                isSavingFuel: false,
                description: this.$props.fuel ? this.$props.fuel.description : ''
            };
        },
        methods:{
            isValid() {
                return !!this.description;
            },
            validBeforeSave() {
                if (this.isValid()) {
                    const actionToPerform = this.edit ? 'updated' : 'created';
                    this.$swal({
                        title: 'Are you sure?',
                        text: `The item will be ${actionToPerform}.`,
                        type: 'warning',
                        showConfirmButton: true,
                        showCancelButton: true
                    }).then(this.save.bind(this));
                } else {
                    this.notifyInvalidForm();
                }
            },
            save() {
                const fuel = {description: this.description},
                    actionPerformed = this.edit ?
                        this.getUpdatePromise(fuel) :
                        this.getCreatePromise(fuel);

                this.isSavingFuel = true;

                actionPerformed.then(res => {
                    const actionToNotify = this.edit ? 'fuel-updated' : 'fuel-created';
                    this.description = '';
                    this.isSavingFuel = false;
                    this.$emit(actionToNotify, res.data);
                });
            },
            getCreatePromise(body) {
                return this.$axios.post(`http://localhost:8000/api/fuels`, body);
            },
            getUpdatePromise(body) {
                return this.$axios.put(`http://localhost:8000/api/fuels/${this.$props.fuel.id}`, body);
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