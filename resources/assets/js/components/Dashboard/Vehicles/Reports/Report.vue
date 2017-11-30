<template>
    <div class="report">
		<div class="col-md-12">
			<p class="text-center">Rents Report</p>
		</div>

	    <div class="col-md-6">
			<input type="date" name="report-since" class="form-control" v-model="since" />
		</div>

		<div class="col-md-6">
			<input type="date" name="report-to" class="form-control" v-model="to" />
		</div>

		<hr>

		<div class="col-md-12">
       		<a class="btn btn-primary btn-fill center-block" id="report-btn" target="_blank" :href="reportLink">Generate Report</a>
		</div>
	</div>
</template>

<script>
export default {
	computed: {
		reportLink() {
			return `/reports?since=${this.since}&to=${this.to}&field=rent_date`;
		}
	},
	data() {
		return {
			since: null,
			to: null
		};
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
