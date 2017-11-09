<template>
    <div class="form-group">
        <input class="border-input" type="checkbox" v-bind="$props" :id="id" :name="name" :value="value" :checked="value"
               :minlength="min" :maxlength="max"
               @input="$emit('input',$event.target.checked)" @blur="$emit('blur', $event.target)"
               @change="$emit('change', $event.target.checked)"/>
        <label v-if="label" :for="name">{{label}}</label>
    </div>
</template>

<style lang="scss" scoped>
    .form-group {
        display: inline-block;
    }
</style>

<script>
    import fgInput from './formGroupInput';

    export default {
        ...fgInput,
        props: {
            ...fgInput.props,
            value: Boolean,
            id: String
        }
    };
</script>