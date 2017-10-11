<template>
    <div class="vehicles">
        <div v-if="!isLoaded">
            <h3>Loading...</h3>
        </div>
        <div v-if="isLoaded">
            Loaded
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                isLoaded: false,
                vehicles: []
            };
        },
        mounted() {
            this.$axios.get('http://localhost:8000/api/vehicles')
                .then(response => {
                    this.vehicles = response.data;
                    this.isLoaded = true;
                });
        }
    };
</script>