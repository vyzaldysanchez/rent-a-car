<template>
    <div class="report">
		<div class="col-md-12">
			<p class="text-center">Rents Report</p>
		</div>

		<div class="col-md-4 col-md-offset-4">
			<fg-select label="Search by" placeholder="Select one of the following" :options="options" 
				:value="field" @change="value => this.field = value"></fg-select>	
		</div>

	    <div class="col-md-6">
			<label for="report-since">Since:</label>
			<input type="date" name="report-since" id="report-since" class="form-control" v-model="since" />
		</div>

		<div class="col-md-6">
			<label for="report-to">To:</label>
			<input type="date" name="report-to" id="report-to" class="form-control" v-model="to" />
		</div>

		<hr>

		<div class="col-md-12">
       		<a class="btn btn-primary btn-fill center-block" id="report-btn" target="_blank" 
			   :href="reportLink" @click="generateReport($event)">Generate Report</a>
		</div>
	</div>
</template>

<script>
export default {
	computed: {
		reportLink() {
			return `/reports?since=${this.since}&to=${this.to}&field=${this
				.field}`;
		}
	},
	data() {
		return {
			since: null,
			to: null,
			field: null,
			get options() {
				return [
					{ value: 'rent_date', label: 'Date' },
					{ value: 'return_date', label: 'Return' }
				];
			}
		};
	},
	methods: {
		generateReport(event) {
			const datesAreMissing = !this.since && !this.to;
			const fieldIsMissing = !this.field;

			let message = '';

			if (datesAreMissing) {
				message = 'Must select at least the "since" date.';
			}

			if (fieldIsMissing) {
				message = 'Must select a field to filter by.';
			}

			if (fieldIsMissing || datesAreMissing) {
				event.preventDefault();
				this.$notifications.notify({
					message,
					type: 'danger',
					verticalAlign: 'bottom',
					horizontalAlign: 'right',
					icon: 'fa fa-warning'
				});
			}
		}
	}
};
</script>

<style lang="scss" scoped>
.report {
	display: flex;
	flex-flow: wrap;

	p {
		font-size: 24px;
	}

	#report-btn {
		margin-top: 15px;
		margin-bottom: 15px;
	}
}
</style>
