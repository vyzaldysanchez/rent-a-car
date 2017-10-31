<template>
    <div class="form-group">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input class="form-control border-input" v-bind="$props" :name="name" :value="value" :minlength="min"
               :maxlength="max" @input="$emit('input',$event.target.value)" @blur="$emit('blur', $event.target)"/>
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
            min: Number
        }
    }

</script>
<style scoped lang="scss">
    label {
        display: flex;
        flex-flow: column;
    }
</style>
