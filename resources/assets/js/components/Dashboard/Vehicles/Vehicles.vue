<template>
    <div class="vehicles">
        <div v-if="!isLoaded">
            <h3>Loading...</h3>
        </div>
        <div v-if="isLoaded">
            <vehicles-form></vehicles-form>

            <hr>

            <table-list :columns="tableColumns" :table-data="vehicles" :use-actions="true"></table-list>
        </div>
    </div>
</template>
<script>
    import TableList from './../../Dashboard/Views/TableList.vue';
    import VehiclesForm from './Forms/VehiclesForm.vue';
    import factory from '../../../factories/factory';

    const tableColumns = ['Ord', 'Description', 'Chassis', 'Engine', 'Plate', 'Type', 'Brand', 'Model', 'Fuel', 'State', 'Actions'];

    export default {
        components: {
            TableList,
            VehiclesForm
        },
        data() {
            return {
                isLoaded: false,
                vehicles: [],
                tableColumns: [...tableColumns]
            };
        },
        mounted() {
            this.$axios.get('http://localhost:8000/api/vehicles')
                .then(response => {
                    this.vehicles = response.data.map((vehicle, index) => {
                        const mappedVehicle = {
                            description: vehicle.description,
                            chassis: vehicle['chassis_number'],
                            engine: vehicle['engine_number'],
                            plate: vehicle['plate_number'],
                            type: vehicle.type.description,
                            model: vehicle.model.description,
                            brand: vehicle.brand.description,
                            fuel: vehicle.fuel.description,
                            state: vehicle.state,
                        };

                        return factory.createForTableList({object: mappedVehicle, index, onEdit: null, onRemove: null});
                    });

                    this.isLoaded = true;
                });
        }
    };
</script>