<template>
    <div class="loader">
        <h2><i class="fa fa-spinner fa-spin"></i></h2>
        <h3><span>{{ message }}</span></h3>
    </div>
</template>

<style lang="scss" scoped>
.loader {
  text-align: center;

  h2, h3 {
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
    }
  },
  data() {
    return {};
  }
};
</script>