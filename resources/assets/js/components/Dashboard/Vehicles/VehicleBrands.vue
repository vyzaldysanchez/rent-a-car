<template>
    <div class="vehicle-brands">
        <div v-if="!isLoaded"><h3>Loading...</h3></div>

        <vehicle-brands-form :edit="brandToUpdate !== null" :brand="brandToUpdate"
                             @brand-created="addBrand" @brand-updated="updateBrand">
        </vehicle-brands-form>

        <hr>

        <table-list v-if="isLoaded" :columns="tableColumns" :use-actions="true" :table-data="brands"></table-list>
    </div>
</template>
<script>
    import VehicleBrandsForm from './Forms/VehicleBrandsForm.vue'
    import TableList from './../Views/TableList.vue'
    import formUtils from '../../../utils/form.utils';

    const vehicleBrandsColumns = ['Ord', 'Description', 'State', 'Actions'];

    export default {
        components: {
            TableList,
            VehicleBrandsForm
        },
        data() {
            return {
                tableColumns: [...vehicleBrandsColumns],
                isLoaded: false,
                brands: [],
                brandToUpdate: null
            };
        },
        mounted() {
            this.$axios.get('http://localhost:8000/api/brands').then(result => {
                this.brands = result.data.map((brand, position) => {
                    const {id, description, state} = brand,
                        vehicleBrand = {ord: position + 1, id, description, state};

                    return formUtils.addActionsTo(vehicleBrand, this.edit, this.askToRemove);
                });

                this.isLoaded = true;
            });
        },
        methods: {
            addBrand(data) {
                const {id, description, state} = data,
                    vehicleBrand = {ord: this.brands.length + 1, id, description, state: state || 'ACTIVE'};

                this.brands.push(formUtils.addActionsTo(vehicleBrand, this.edit, this.askToRemove));
            },
            updateBrand(data) {
                this.brands = this.brands.map(brand => {
                    if (brand.id === data.id) {
                        brand = Object.assign(brand, {description: data.description});
                    }

                    return brand;
                });
            },
            edit(brand) {
                this.brandToUpdate = brand;
            },
            askToRemove(brand) {
                this.$swal({
                    title: 'Are you sure?',
                    text: `The brand and all it\'s data associated will be deleted.`,
                    type: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then(() => this.remove(brand));
            },
            remove(brand) {
                this.$axios.delete(`http://localhost:8000/api/brands/${brand.id}`)
                    .then(() => {
                        const index = this.brands.findIndex(vehicleBrand => brand.id === vehicleBrand.id);
                        this.brands = this.brands.slice(0, index).concat(this.brands.slice(index + 1));
                    });
            }
        }
    };
</script>