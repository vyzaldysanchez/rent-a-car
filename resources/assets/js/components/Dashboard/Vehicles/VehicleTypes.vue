<template>
    <div class="vehicle-types">
        <div v-if="!loaded">
            <h3 class="text-center">Loading data...</h3>
        </div>
        <table-list v-if="loaded" :columns="propsToDisplay" :tableData="vehicleTypes"></table-list>
    </div>
</template>
<script>
    import TableList from './../Views/TableList.vue'

    const vehicleTypesColumns = ['Ord', 'Description', 'State'];

    export default {
        components: {
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
        }
    };
</script>
<style scoped lang="scss"></style>