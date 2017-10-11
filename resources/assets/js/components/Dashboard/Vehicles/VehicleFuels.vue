<template>
    <div class="vehicle-fuels">
        <div v-if="!isLoaded">
            <h3>Loading...</h3>
        </div>
        <div v-if="isLoaded">
            <vehicle-fuels-form :edit="fuelToUpdate !== null" :fuel="fuelToUpdate" @fuel-created="addFuel"
                                @fuel-updated="updateFuel"></vehicle-fuels-form>

            <hr>

            <table-list :columns="tableColumns" :use-actions="true" :table-data="fuels"></table-list>
        </div>
    </div>
</template>
<script>
    import VehicleFuelsForm from './Forms/VehicleFuelsForm.vue';
    import TableList from './../Views/TableList.vue';
    import factory from './../../../factories/factory';

    const tableColumns = ['Ord', 'Description', 'State', 'Actions'];

    export default {
        components: {
            VehicleFuelsForm,
            TableList
        },
        data() {
            return {
                isLoaded: false,
                tableColumns,
                fuels: [],
                fuelToUpdate: null
            };
        },
        mounted() {
            this.$axios.get(`http://localhost:8000/api/fuels`)
                .then(response => {
                    this.fuels = response.data.map((fuel, index) => {
                        return factory.createForTableList({
                            object: fuel,
                            index,
                            onEdit: this.edit,
                            onRemove: this.askToRemove
                        });
                    });
                    this.isLoaded = true;
                });
        },
        methods: {
            addFuel(data) {
                let fuel = Object.assign(data, {state: data.state || 'ACTIVE'});

                fuel = factory.createForTableList({
                    object: fuel,
                    index: this.fuels.length,
                    onEdit: this.edit,
                    onRemove: this.askToRemove
                });

                this.fuels.push(fuel);
            },
            edit(model) {
                this.fuelToUpdate = model;
            },
            updateFuel(data) {
                this.fuels = this.fuels.map(fuel => {
                    if (fuel.id === data.id) {
                        fuel = Object.assign(fuel, {description: data.description});
                    }

                    return fuel;
                });
            },
            edit(fuel) {
                this.fuelToUpdate = fuel;
            },
            askToRemove(fuel) {
                this.$swal({
                    title: 'Are you sure?',
                    text: `The fuel and all it\'s data associated will be deleted.`,
                    type: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then(() => this.remove(fuel));
            },
            remove(fuel) {
                this.$axios.delete(`http://localhost:8000/api/fuels/${fuel.id}`)
                    .then(() => {
                        const index = this.fuels.findIndex(vehicleFuel => fuel.id === vehicleFuel.id);
                        this.fuels = this.fuels.slice(0, index).concat(this.fuels.slice(index + 1));
                    });
            }
        }
    };
</script>
