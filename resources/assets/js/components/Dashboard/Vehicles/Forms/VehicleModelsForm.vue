<template>
    <div class="vehicle-brands-form">
        <form>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <fg-input label="Description" placeholder="Description..." :required="true" v-model="description">
                    </fg-input>

                    <fg-select label="Brand" name="brand" id="brand" v-model="brandId" :options="brandsOptions"
                               placeholder="Select a brand from the list below..."></fg-select>

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
            brands: Array
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
        }
    };
</script>