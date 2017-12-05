<template>
    <div class="form-group">
        <label :for="name">{{label}}</label>
        <input class="border-input form-control" type="range" v-bind="$props" :name="name" :id="id" :value="value"
               :list="list" :step="step" :min="min" :max="max" @input="$emit('input',$event.target.value)"
               @blur="$emit('blur', $event.target)" @change="$emit('change', $event)"/>

        <datalist :id="list">
            <option v-for="(listItem, index) in listValues" :key="index" 
                :value="listItem.value" :label="`${listItem.label}`" />
        </datalist>
    </div>
</template>

<script>
import fgInput from './formGroupInput.vue';

export default {
	...fgInput,
	props: {
		...fgInput.props,
		id: String,
		step: Number,
		list: String,
		listValues: Array,
		min: Number,
		max: Number
	}
};
</script>
