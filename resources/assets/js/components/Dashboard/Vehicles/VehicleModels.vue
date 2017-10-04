<template>
    <div class="vehicle-models">
        <div v-if="!isLoaded"><h3>Loading...</h3></div>

        <vehicle-models-form :edit="modelToUpdate !== null" :model="modelToUpdate" :brands="brands"
                             @brand-created="addModel" @brand-updated="updateModel">
        </vehicle-models-form>

        <hr>

        <table-list v-if="isLoaded" :columns="tableColumns" :use-actions="true" :table-data="models"></table-list>
    </div>
</template>
<script>
    import TableList from './../Views/TableList.vue'
    import VehicleModelsForm from './Forms/VehicleModelsForm.vue'
    import brandsFactory from '../../../factories/brands.factory';

    const tableColumns = ['Ord', 'Description', 'Brand', 'State', 'Actions'];

    export default {
        components: {
            TableList,
            VehicleModelsForm
        },
        mounted() {
            Promise.all([
                this.$axios.get('http://localhost:8000/api/brands'),
                this.$axios.get('http://localhost:8000/api/models')
            ]).then(response => {
                const [brandsResponse, modelsResponse] = response;

                this.brands = brandsResponse.data.map((brand, index) => brandsFactory.createBrand({brand, index}));
                this.models = modelsResponse.data.map((model, index) => {
                    const vehicleModel = Object.assign(model, {
                        ord: index + 1,
                        brandObj: this.brands.find(brand => brand.id === model['vehicle_brand_id'])
                    });

                    vehicleModel.brand = vehicleModel.brandObj ? vehicleModel.brandObj.description : '';

                    delete vehicleModel['vehicle_brand_id'];

                    return vehicleModel;
                });

                this.isLoaded = true;
            });
        },
        data() {
            return {
                isLoaded: false,
                tableColumns: [...tableColumns],
                brands: [],
                models: [],
                modelToUpdate: null
            };
        },
        methods: {
            addModel() {
            },
            updateModel() {
            }
        }
    };
</script>