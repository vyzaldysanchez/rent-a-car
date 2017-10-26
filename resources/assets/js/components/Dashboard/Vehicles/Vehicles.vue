<template>
    <div class="vehicles">
        <div v-if="!isLoaded">
            <h3>Loading...</h3>
        </div>
        <div v-if="isLoaded">
            <vehicles-form @vehicle-created="addVehicle"></vehicles-form>

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
                            id: vehicle.id,
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

                        return factory.createForTableList({
                            object: mappedVehicle,
                            index,
                            onEdit: null,
                            onRemove: this.askToRemove
                        });
                    });

                    this.isLoaded = true;
                });
        },
        methods: {
            addVehicle(data) {
                const mappedVehicle = {
                        id: data.id,
                        description: data.description,
                        chassis: data['chassis_number'],
                        engine: data['engine_number'],
                        plate: data['plate_number'],
                        type: data.type.description,
                        model: data.model.description,
                        brand: data.brand.description,
                        fuel: data.fuel.description,
                        state: data.state || 'AVAILABLE',
                    },
                    index = this.vehicles.length;

                this.vehicles.push(factory.createForTableList({
                    object: mappedVehicle,
                    index,
                    onEdit: null,
                    onRemove: this.askToRemove
                }));
            },
            askToRemove(vehicle) {
                this.$swal({
                    title: 'Are you sure?',
                    text: `The vehicle and all it\'s data associated will be deleted.`,
                    type: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then(() => this.removeVehicle(vehicle));
            },
            removeVehicle(vehicle) {
                this.$axios.delete(`http://localhost:8000/api/vehicles/${vehicle.id}`)
                    .then(() => {
                        const index = this.vehicles.findIndex(storedVehicle => vehicle.id === storedVehicle.id);
                        this.vehicles = this.vehicles.slice(0, index).concat(this.vehicles.slice(index + 1));
                    });
            }
        }
    };
</script>