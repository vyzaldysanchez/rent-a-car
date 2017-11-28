<template>
    <div id="vechile-rent-container">
        <loading-message v-if="!loaded" :only-icon="true"></loading-message>

        <vehicle-rent-form :class="{hidden: !loaded}" @loaded="setAsLoaded"></vehicle-rent-form>
    </div>
</template>

<script>
import VehicleRentForm from './Forms/VehicleRentForm.vue';

export default {
  components: {
    VehicleRentForm
  },
  data() {
    return {
      loaded: false
    };
  },
  methods: {
    setAsLoaded() {
      this.loaded = true;
    }
  }
};
</script>