<template>
    <div class="vehicle-types">
        <table-list></table-list>
    </div>
</template>
<script>
    import TableList from './../Views/TableList.vue'

    export default {
        components: {
            TableList
        },
        data() {
            return {};
        },
        mounted() {
            this.$axios.get('http://localhost:8000/api/vehicles/types')
                .then((res) => {
                    console.log(res);
                });
        }
    };
</script>
<style scoped lang="scss"></style>