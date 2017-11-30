<template>
    <div class="rents-collection">
        <loading-message v-if="!loaded"></loading-message>
        
		<div v-if="loaded">
			<report v-if="rents.length" />

			<hr />	

            <table-list title="Rents" :columns="tableColumns" :table-data="tableRents"></table-list>
        </div>
    </div>
</template>

<script>
import TableList from './../Views/TableList.vue';
import Report from './Reports/Report.vue';

const columns = ['Vehicle', 'Client', 'Date', 'Return', 'Duration'];

export default {
	components: {
		TableList,
		Report
	},
	data() {
		return {
			loaded: false,
			rents: []
		};
	},
	computed: {
		tableColumns() {
			return columns;
		},
		tableRents() {
			return this.rents.map(rent => ({
				date: rent.rent_date,
				return: rent.return_date,
				duration: rent.duration_in_days,
				vehicle: rent.vehicle,
				client: rent.client
			}));
		}
	},
	created() {
		this.$axios.get('/api/rents').then(({ data }) => {
			this.rents = data || [];
			this.loaded = true;
		});
	}
};
</script>
