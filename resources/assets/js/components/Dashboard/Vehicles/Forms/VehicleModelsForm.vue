<template>
    <div class="vehicle-brands-form">
        <form>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <fg-input label="Description" placeholder="Description..." :required="true" v-model="description">
                    </fg-input>

                    <fg-select label="Brand" name="brand" id="brand" :options="brandsOptions" v-model="brandId"
                               placeholder="Select a brand from the list below..." @change="updateBrandId"></fg-select>

                    <div class="text-center">
                        <button class="btn btn-info btn-fill btn-wd" :class="{'disabled': isSavingModel}"
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
        props: {
            model: Object,
            brands: Array,
            edit: Boolean
        },
        watch: {
            model(newValue) {
                this.description = newValue ? newValue.description : '';
                this.brandId = newValue ? newValue.brandId : null;
            }
        },
        components: {
            PaperNotification
        },
        computed: {
            brandsOptions() {
                return this.$props.brands.map(brand => ({value: brand.id, label: brand.description}));
            }
        },
        data() {
            return {
                description: this.$props.model ? this.$props.model.description : '',
                isSavingModel: false,
                brandId: this.$props.brandId ? this.$props.model.brandId : null
            };
        },
        methods: {
            updateBrandId(id) {
                this.brandId = id;
            },
            isFormValid() {
                return !!this.description.trim() && !!this.brandId;
            },
            validBeforeSave() {
                if (this.isFormValid()) {
                    const actionToPerform = this.edit ? 'updated' : 'created';

                    this.$swal({
                        title: 'Are you sure?',
                        html: `The vehicle model <b>${this.description}</b> will be ${actionToPerform}.`,
                        type: 'warning',
                        showConfirmButton: true,
                        showCancelButton: true
                    }).then(this.save.bind(this));
                } else {
                    this.notifyInvalidForm();
                }
            },
            save() {
                const body = {description: this.description, 'vehicle_brand_id': this.brandId},
                    actionPerformed = this.edit ?
                        this.getUpdatePromise(body) :
                        this.getCreatePromise(body);

                this.isSavingBrand = true;

                actionPerformed.then(res => {
                    const actionToNotify = this.edit ? 'model-updated' : 'model-created';
                    this.description = '';
                    res.data.brandId = this.brandId;
                    this.brandId = null;
                    this.isSavingModel = false;
                    this.$emit(actionToNotify, res.data);
                });
            },
            getCreatePromise(body) {
                return this.$axios.post(`http://localhost:8000/api/models`, body);
            },
            getUpdatePromise(body) {
                return this.$axios.put(`http://localhost:8000/api/models/${this.$props.model.id}`, body);
            },
            notifyInvalidForm() {
                let errorMessage = '';

                if (!this.brandId) {
                    errorMessage = 'A brand must be selected to continue.';
                }

                if (!this.description.trim()) {
                    errorMessage = 'The description field is empty.';
                }

                this.$notifications.notify({
                    message: errorMessage,
                    type: 'danger',
                    verticalAlign: 'bottom',
                    horizontalAlign: 'right',
                    icon: 'fa fa-warning'
                });
            }
        }
    };
</script>