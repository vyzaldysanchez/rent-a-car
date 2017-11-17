<template>
    <div class="loader">
        <h2><i class="fa fa-spinner fa-spin"></i></h2>
        <h3 v-if="!onlyIcon"><span>{{ message }}</span></h3>
    </div>
</template>

<style lang="scss" scoped>
.loader {
  text-align: center;

  h2,
  h3 {
    display: block;
  }
}
</style>


<script>
export default {
  props: {
    message: {
      type: String,
      default: 'Loading...'
    },
    onlyIcon: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {};
  }
};
</script>