<template>
    <div class="vehicle-models">
        <div v-if="!isLoaded">
            <h3>Loading...</h3>
        </div>

        <vehicle-models-form :edit="modelToUpdate !== null" :model="modelToUpdate" :brands="brands"
                             @model-created="addModel" @model-updated="updateModel">
        </vehicle-models-form>

        <hr>

        <table-list v-if="isLoaded" :columns="tableColumns" :use-actions="true" :table-data="models"></table-list>
    </div>
</template>
<script>
    import TableList from './../Views/TableList.vue'
    import VehicleModelsForm from './Forms/VehicleModelsForm.vue'
    import brandsFactory from '../../../factories/brands.factory'
    import modelsFactory from '../../../factories/models.factory'

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
                    const brand = this.brands.find(brand => brand.id == model['vehicle_brand_id']);

                    delete model['vehicle_brand_id'];

                    return modelsFactory.createModelForTableList({
                        model,
                        brand,
                        index,
                        onEdit: this.edit,
                        onRemove: this.askToRemove
                    });
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
            addModel(data) {
                let model = Object.assign(data, {state: data.state || 'ACTIVE'});

                const index = this.models.length + 1,
                    brand = this.brands.find(brand => brand.id == model['vehicle_brand_id']);

                model = modelsFactory.createModelForTableList({
                    model,
                    brand,
                    index,
                    onEdit: this.edit,
                    onRemove: this.askToRemove
                });

                this.models.push(model);
            },
            edit(model) {
                this.modelToUpdate = model;
            },
            updateModel(data) {
                this.models = this.models.map(model => {
                    if (model.id === data.id) {
                        model = Object.assign(model, {description: data.description, brandId: data.brandId});
                        model.brand = this.brands.find(brand => brand.id == model.brandId).description;
                    }

                    return model;
                });
            },
            askToRemove(model) {
                this.$swal({
                    title: 'Are you sure?',
                    text: `The model and all it\'s data associated will be deleted.`,
                    type: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then(() => this.remove(model));
            },
            remove(model) {
                this.$axios.delete(`http://localhost:8000/api/models/${model.id}`)
                    .then(() => {
                        const index = this.models.findIndex(vehicleModel => model.id === vehicleModel.id);
                        this.brands = this.models.slice(0, index).concat(this.models.slice(index + 1));
                    });
            }
        }
    };
</script>