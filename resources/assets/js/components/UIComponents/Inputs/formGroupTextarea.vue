<template>
  <div class="text-area">
      <label :for="id">{{label}}</label>
      <textarea :name="name" :id="id" :cols="cols" :rows="rows" v-bind="$props" :minlength="min" :maxlength="max" @input="$emit('input',$event.target.value)"
               @blur="$emit('blur', $event.target)" @change="$emit('change', $event)"></textarea>
  </div>
</template>

<script>
import fgInput from './formGroupInput.vue';

export default {
  ...fgInput,
  props: {
    ...fgInput.props,
    id: String,
    cols: Number,
    rows: Number
  }
};
</script>

<style lang="scss" scoped>
textarea {
  display: block;
  width: 100%;
  height: 10em;
}
</style>