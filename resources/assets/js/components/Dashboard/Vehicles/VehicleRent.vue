<template>
    <div id="vechile-rent-container">
        <loading-message v-if="!loaded" :message="message"></loading-message>
    </div>
</template>

<script>
export default {
  data() {
    return {
      loaded: false,
      get message() {
        return 'Loading the rents module, please wait a moment...';
      }
    };
  }
};
</script>