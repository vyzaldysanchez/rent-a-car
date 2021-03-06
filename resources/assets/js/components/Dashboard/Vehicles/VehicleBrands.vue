<template>
    <div class="vehicle-brands">
        <div v-if="!isLoaded">
            <h3 class="text-center">Loading...</h3>
        </div>

        <div v-if="isLoaded">
            <vehicle-brands-form :edit="brandToUpdate !== null" :brand="brandToUpdate"
                                 @brand-created="addBrand" @brand-updated="updateBrand">
            </vehicle-brands-form>

            <hr>

            <table-list :columns="tableColumns" :use-actions="true" :table-data="brands"></table-list>
        </div>
    </div>
</template>
<script>
    import VehicleBrandsForm from './Forms/VehicleBrandsForm.vue'
    import TableList from './../Views/TableList.vue'
    import formUtils from '../../../utils/form.utils';
    import brandsFactory from '../../../factories/brands.factory';

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
                this.brands = (result.data || []).map(
                    (brand, index) => brandsFactory.createBrandForTableList({
                        brand,
                        index,
                        onEdit: this.edit,
                        onRemove: this.askToRemove
                    })
                );

                this.isLoaded = true;
            });
        },
        methods: {
            addBrand(data) {
                const index = this.brands.length;
                let brand = Object.assign(data, {state: data.state || 'ACTIVE'});

                brand = brandsFactory.createBrandForTableList({
                    brand,
                    index,
                    onEdit: this.edit,
                    onRemove: this.askToRemove
                });

                this.brands.push(brand);
            },
            updateBrand(data) {
                this.brands = this.brands.map(brand => {
                    if (brand.id === data.id) {
                        brand = Object.assign(brand, {description: data.description});
                    }

                    return brand;
                });
                this.brandToUpdate = null;
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