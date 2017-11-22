<template>
    <div class="form-group">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <select class="form-control border-input" :name="name" :id="id" v-bind="$props" :value="value"
                @change="$emit('change', $event.target.value)">
            <option v-if="placeholder" disabled :value="null">{{placeholder}}</option>
            <option v-for="(option, index) in options" v-bind:key="index" :value="option.value">
                {{option.label}}
            </option>
        </select>
    </div>
</template>
<script>
    export default {
        props: {
            label: String,
            name: String,
            id: String,
            value: [String, Number],
            placeholder: String,
            options: Array
        },
        data() {
            return {};
        }
    };
</script>
<style scoped lang="scss">
    label {
        display: flex;
        flex-flow: column;
    }
</style>