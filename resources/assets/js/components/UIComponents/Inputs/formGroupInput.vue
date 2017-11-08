<template>
    <div class="form-group">
        <label v-if="label" :for="name">
                {{label}}
            </label>
        <input class="border-input" :class="{'form-control': asFormControl}" v-bind="$props" :name="name" :value="value" :minlength="min" :maxlength="max" @input="$emit('input',$event.target.value)" @blur="$emit('blur', $event.target)" @change="$emit('change', $event)" />
    </div>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'text'
    },
    label: String,
    name: String,
    disabled: Boolean,
    placeholder: String,
    value: [String, Number],
    max: Number,
    min: Number,
    asFormControl: {
      type: Boolean,
      default: true
    }
  }
};
</script>

<style scoped lang="scss">
label {
  display: flex;
  flex-flow: column;
}
</style>
