<template>
    <div class="vehicle-types">
        <div v-if="!loaded">
            <h3 class="text-center">Loading...</h3>
        </div>
        <div v-if="loaded">
            <vehicle-types-form :edit="vehicleTypeToEdit !== null" :vehicle-type="vehicleTypeToEdit" @type-created="addVehicleType" @type-updated="updateVehicleType">
            </vehicle-types-form>
    
            <hr>
    
            <table-list :columns="propsToDisplay" v-bind:tableData="vehicleTypes" :use-actions="true"></table-list>
        </div>
    </div>
</template>

<script>
    import TableList from './../Views/TableList.vue'
    import VehicleTypesForm from './Forms/VehicleTypesForm.vue'
    import formUtils from './../../../utils/form.utils'
    
    const vehicleTypesColumns = ['Ord', 'Description', 'State', 'Actions'];
    
    export default {
        components: {
            VehicleTypesForm,
            TableList
        },
        data() {
            return {
                loaded: false,
                propsToDisplay: [...vehicleTypesColumns],
                vehicleTypes: [],
                vehicleTypeToEdit: null
            };
        },
        mounted() {
            this.$axios.get('http://localhost:8000/api/types').then((res) => {
                this.vehicleTypes = (res.data || []).map((type, position) => {
                    const {
                        id,
                        description,
                        state
                    } = type,
                    vehicleType = {
                        ord: position + 1,
                        id,
                        description,
                        state
                    };
    
                    return formUtils.addActionsTo(vehicleType, this.edit, this.askToRemove);
                });
                this.loaded = true;
            });
        },
        methods: {
            addVehicleType(data) {
                const {
                    id,
                    description,
                    state
                } = data,
                vehicleType = {
                    ord: this.vehicleTypes.length + 1,
                    id,
                    description,
                    state: state || 'ACTIVE'
                };
    
                this.vehicleTypes.push(formUtils.addActionsTo(vehicleType, this.edit, this.askToRemove));
            },
            updateVehicleType(data) {
                this.vehicleTypes = this.vehicleTypes.map(type => {
                    if (type.id === data.id) {
                        type = Object.assign(type, {
                            description: data.description
                        });
                    }
    
                    return type;
                });
    
                this.vehicleTypeToEdit = null;
            },
            edit(vehicleType) {
                this.vehicleTypeToEdit = vehicleType;
            },
            askToRemove(vehicleType) {
                this.$swal({
                    title: 'Are you sure?',
                    text: `The item and all it\'s data associated will be deleted.`,
                    type: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then(() => this.remove(vehicleType));
            },
            remove(vehicleType) {
                this.$axios.delete(`http://localhost:8000/api/types/${vehicleType.id}`)
                    .then(() => {
                        const index = this.vehicleTypes.findIndex(type => vehicleType.id === type.id);
                        this.vehicleTypes = this.vehicleTypes.slice(0, index)
                            .concat(this.vehicleTypes.slice(index + 1));
                    });
            }
        }
    };
</script>

<style scoped lang="scss">
    
</style>