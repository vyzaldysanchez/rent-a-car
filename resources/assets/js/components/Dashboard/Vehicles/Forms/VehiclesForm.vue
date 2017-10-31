<template>
    <div class="vehicles-form">
        <form>
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Description" placeholder="Vehicle Description..." v-model="description"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input label="Chasis No." placeholder="AESFAIAS7676Q..." :min="17" :max="17" v-model="chassis"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Engine No." placeholder="ADFGHGREADSDFSDR..." :min="11" :max="11" v-model="engine"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input label="Plate No." placeholder="ADFGHGREADSDFSDR..." :min="8" :max="8" v-model="plate"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-select label="Vehicle type" placeholder="Select a vehicle type from the list below..." v-model="typeId" :options="types" @change="updateType"></fg-select>
                </div>
                <div class="col-md-5">
                    <fg-select label="Vehicle brand" placeholder="Select a brand from the list below..." v-model="brandId" :options="brands" @change="updateBrand"></fg-select>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-select label="Vehicle model" placeholder="Select a model from the list below..." v-model="modelId" :options="models" @change="updateModel"></fg-select>
                </div>
                <div class="col-md-5">
                    <fg-select label="Fuel" placeholder="Select a fuel type from the list below..." v-model="fuelId" :options="fuels" @change="updateFuel"></fg-select>
                </div>
    
                <div class="text-center">
                    <button class="btn btn-info btn-fill btn-wd" :class="{'disabled': isSavingVehicle}" @click.prevent="validBeforeSave">
                                                                        Save
                                                                    </button>
                </div>
            </div>
        </form>
    
        <notifications></notifications>
    </div>
</template>

<script>
    import PaperNotification from '../../../UIComponents/NotificationPlugin/Notifications.vue';
    
    export default {
        components: {
            PaperNotification
        },
        props: {
            vehicle: Object
        },
        watch: {
            chassis(value) {
                this.chassis = value.slice(0, 17).toUpperCase();
            },
            engine(value) {
                this.engine = value.slice(0, 11).toUpperCase();
            },
            plate(value) {
                this.plate = value.slice(0, 8).toUpperCase();
            },
            vehicle(vehicle) {
                if (this.edit = !!vehicle) {
                    for (let vehicleProp of Object.keys(vehicle)) {
                        if (vehicleProp in this) {
                            this[vehicleProp] = vehicle[vehicleProp];
                        }
                    }
                }
            }
        },
        data() {
            return {
                description: '',
                chassis: '',
                engine: '',
                plate: '',
                brandId: null,
                modelId: null,
                typeId: null,
                fuelId: null,
                types: [],
                brands: [],
                models: [],
                fuels: [],
                typesSource: [],
                brandsSource: [],
                modelsSource: [],
                fuelsSource: [],
                isSavingVehicle: false,
                formError: '',
                edit: !!this.$props.vehicle
            };
        },
        mounted() {
            this.getInitialDataPromise().then(response => {
                const [types, models, brands, fuels] = response;
    
                this.typesSource = types.data || [];
                this.modelsSource = models.data || [];
                this.brandsSource = brands.data || [];
                this.fuelsSource = fuels.data || [];
    
                this.types = this.typesSource.map(type => ({
                    value: type.id,
                    label: type.description
                }));
                this.models = this.modelsSource.map(model => ({
                    value: model.id,
                    label: model.description
                }));
                this.brands = this.brandsSource.map(brand => ({
                    value: brand.id,
                    label: brand.description
                }));
                this.fuels = this.fuelsSource.map(fuel => ({
                    value: fuel.id,
                    label: fuel.description
                }));
            });
        },
        methods: {
            getInitialDataPromise() {
                return Promise.all([
                    this.$axios.get('http://localhost:8000/api/types'),
                    this.$axios.get('http://localhost:8000/api/models'),
                    this.$axios.get('http://localhost:8000/api/brands'),
                    this.$axios.get('http://localhost:8000/api/fuels')
                ]);
            },
            isFormValid() {
                this.formError = '';
    
                switch (true) {
                    case !this.description:
                        this.formError = 'The description is required';
                        break;
                    case !this.chassis:
                        this.formError = 'The chassis is required';
                        break;
                    case this.chassis.length !== 17:
                        this.formError = 'The chassis is not long enough';
                        break;
                    case !this.engine:
                        this.formError = 'The engine is required';
                        break;
                    case this.engine.length !== 11:
                        this.formError = 'The engine is not long enough';
                        break;
                    case !this.plate:
                        this.formError = 'The plate is required';
                        break;
                    case this.plate.length !== 8:
                        this.formError = 'The plate is not long enough';
                        break;
                    case !this.typeId:
                        this.formError = 'The vehicle type is required';
                        break;
                    case !this.brandId:
                        this.formError = 'The brand is required';
                        break;
                    case !this.modelId:
                        this.formError = 'The model is required';
                        break;
                    case !this.fuelId:
                        this.formError = 'The fuel is required';
                        break;
                }
    
                return !!this.formError;
            },
            validBeforeSave() {
                if (this.isSavingVehicle) {
                    return;
                }
    
                if (this.isFormValid()) {
                    const actionToPerform = this.edit ? 'updated' : 'created';
    
                    this.$swal({
                        title: 'Are you sure?',
                        html: `The vehicle <b>${this.description}</b> will be ${actionToPerform}.`,
                        type: 'warning',
                        showConfirmButton: true,
                        showCancelButton: true
                    }).then(this.save.bind(this));
                } else {
                    this.notifyFormError(this.formError);
                }
            },
            save() {
                const body = {
                        description: this.description,
                        'chassis_number': this.chassis,
                        'engine_number': this.engine,
                        'plate_number': this.plate,
                        'vehicle_brand_id': this.brandId,
                        'vehicle_type_id': this.typeId,
                        'vehicle_model_id': this.modelId,
                        'fuel_id': this.fuelId
                    },
                    actionPerformed = this.edit ?
                    this.getUpdatePromise(body) :
                    this.getCreatePromise(body);
    
                this.isSavingBrand = true;
    
                actionPerformed.then(res => {
                    const actionToNotify = this.edit ? 'vehicle-updated' : 'vehicle-created';
                    this.isSavingModel = false;
                    res.data.brand = this.brandsSource.find(brand => brand.id == this.brandId);
                    res.data.model = this.modelsSource.find(model => model.id == this.modelId);
                    res.data.type = this.typesSource.find(type => type.id == this.typeId);
                    res.data.fuel = this.fuelsSource.find(fuel => fuel.id == this.fuelId);
    
                    this.clearForm();
                    this.$emit(actionToNotify, res.data);
                });
            },
            getCreatePromise(body) {
                return this.$axios.post(`http://localhost:8000/api/vehicles`, body);
            },
            getUpdatePromise(body) {
                return this.$axios.put(`http://localhost:8000/api/vehicles/${this.$props.vehicle.id}`, body);
            },
            notifyFormError(error) {
                this.$notifications.notify({
                    message: error,
                    type: 'danger',
                    verticalAlign: 'bottom',
                    horizontalAlign: 'right',
                    icon: 'fa fa-warning'
                });
            },
            updateType(id) {
                this.typeId = id;
            },
            updateModel(id) {
                this.modelId = id;
            },
            updateBrand(id) {
                this.brandId = id;
            },
            updateFuel(id) {
                this.fuelId = id;
            },
            clearForm() {
                this.description = '';
                this.chassis = '';
                this.engine = '';
                this.plate = '';
                this.brandId = null;
                this.modelId = null;
                this.typeId = null;
                this.fuelId = null;
            }
        }
    };
</script>