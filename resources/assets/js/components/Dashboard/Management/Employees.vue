<template>
    <div class="employees">
        <div v-if="!isLoaded">
            <h3 class="text-center">Loading...</h3>
        </div>
        <div v-if="isLoaded"></div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                isLoaded: false
            };
        }
    };
</script>