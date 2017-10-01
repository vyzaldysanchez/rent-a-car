<template>
    <div class="vehicle-types">
        <div v-if="!loaded">
            <h3 class="text-center">Loading data...</h3>
        </div>
        <vehicle-types-form @type-created="addVehicleType"></vehicle-types-form>

        <hr>

        <table-list v-if="loaded" :columns="propsToDisplay" v-bind:tableData="vehicleTypes"></table-list>
    </div>
</template>
<script>
    import TableList from './../Views/TableList.vue'
    import VehicleTypesForm from './Forms/VehicleTypesForm.vue'

    const vehicleTypesColumns = ['Ord', 'Description', 'State'];

    export default {
        components: {
            VehicleTypesForm,
            TableList
        },
        data() {
            return {
                loaded: false,
                propsToDisplay: [...vehicleTypesColumns],
                vehicleTypes: []
            };
        },
        mounted() {
            this.$axios.get('http://localhost:8000/api/types').then((res) => {
                    this.vehicleTypes = res.data.map((type, position) => {
                        const {id, description, state} = type;

                        return {ord: position + 1, id, description, state};
                    });
                    this.loaded = true;
                }
            );
        },
        methods: {
            addVehicleType(data) {
                const {id, description, state} = data,
                    vehicleType = {ord: this.vehicleTypes.length + 1, id, description, state: state || 'ACTIVE'};

                this.vehicleTypes.push(vehicleType);
            }
        }
    };
</script>
<style scoped lang="scss"></style>