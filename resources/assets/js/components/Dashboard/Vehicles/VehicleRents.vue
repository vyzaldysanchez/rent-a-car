<template>
    <div class="rents-collection">
        <loading-message v-if="!loaded"></loading-message>
        
		<div v-if="loaded">
			<report v-if="rents.length" />

			<hr />	

            <table-list title="Rents" :columns="tableColumns" :table-data="tableRents" :use-actions="true"></table-list>
        </div>
    </div>
</template>

<script>
import TableList from './../Views/TableList.vue';
import Report from './Reports/Report.vue';

const columns = [
	'Vehicle',
	'Client',
	'Date',
	'Return',
	'Duration',
	'State',
	'Actions'
];

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
				id: rent.id,
				date: rent.rent_date,
				return: rent.return_date,
				duration: rent.duration_in_days,
				vehicle: rent.vehicle,
				client: rent.client,
				state: rent.state.toUpperCase(),
				actions: [
					{
						text: '<button class="btn btn-danger">End</button>',
						click: this.confirmRentEnding.bind(this, rent.id),
						classes: 'text-danger'
					}
				]
			}));
		}
	},
	created() {
		this.$axios.get('/api/rents').then(({ data }) => {
			this.rents = data || [];
			this.loaded = true;
		});
	},
	methods: {
		confirmRentEnding(id) {
			this.$swal({
				title: 'Are you sure?',
				html: `The rent will be ended.`,
				type: 'warning',
				showConfirmButton: true,
				showCancelButton: true
			}).then(this.endRent.bind(this, id));
		},
		endRent(id) {
			this.$axios
				.put(`/api/rents/${id}`, { state: 'ended' })
				.then(res => {
					this.rents = this.rents.map(
						rent => (rent.id === res.data.id ? res.data : rent)
					);
				});
		}
	}
};
</script>
