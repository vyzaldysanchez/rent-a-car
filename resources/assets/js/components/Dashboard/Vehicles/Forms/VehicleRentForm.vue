<template>
  <div id="rents-form">
    <h2 class="title text-center">Rent a car! <i class="ti-car"></i></h2>

    <hr />

    <form>
      <div class="col-md-6 form-group">
        <fg-input type="date" id="rentDate" name="rentDate" label="Rent date" v-model="rent.date"></fg-input>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="date" id="returnDate" name="returnDate" label="Return date" v-model="rent.returnDate"></fg-input>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="number" id="fair" name="fair" label="Daily fair" v-model="rent.dailyFair" :min="0.00"></fg-input>
      </div>
      
      <div class="col-md-12 form-group">
        <fg-textarea label="Comment" id="comment" name="comment" v-model="rent.comment"></fg-textarea>
      </div>

      <div class="col-md-12 form-group">
        <button type="button" class="btn btn-primary btn-fill center-block" :class="{'disabled': isCreatingRent}"
            @click.prevent="validBeforeSave">Save
        </button>
      </div>
    </form>
  </div>
</template>

<style lang="scss" scoped>
.title {
	margin: 15px 0;
}
</style>


<script>
import { AUTH_USER_KEY } from '../../../../services/user.service';
import { RENT_INSPECTION } from './../../../../utils/form.utils';

export default {
	data() {
		return {
			rent: this.createInitialRent(),
			isValid: false,
			errors: [],
			isCreatingRent: false,
			employeeId: 0,
			inspection: null
		};
	},
	created() {
		this.getFormDataRequest().then(res => {
			const [user, inspection] = res;

			console.log(RENT_INSPECTION);

			this.employeeId = user.employeeId;
			this.inspection = inspection;

			this.$emit('loaded');
		});
	},
	methods: {
		getFormDataRequest() {
			return Promise.all([
				this.$storage.getItem(AUTH_USER_KEY),
				this.$storage.getItem(RENT_INSPECTION)
			]);
		},
		selectVehicle(id) {
			this.rent.vehicleId = id;
		},
		selectClient(id) {
			this.rent.clientId = id;
		},
		validBeforeSave() {
			this.isCreatingRent = true;
			this.validate();
			this.isCreatingRent = false;
		},
		validate() {
			this.errors = [];
			this.isValid = true;

			this.validateDailyFair();
			this.validateRentDate();
			this.validateReturnDate();

			if (this.errors.length) {
				this.notifyErrors();
			} else {
				this.$swal({
					title: 'Are you sure?',
					html: `The rent will be created.`,
					type: 'warning',
					showConfirmButton: true,
					showCancelButton: true
				}).then(this.save.bind(this));
			}
		},
		validateDailyFair() {
			if (!this.rent.dailyFair) {
				this.errors.push('Must define a fair to be charged daily.');
			}

			this.isValid = this.isValid && this.rent.dailyFair > 0;
		},
		validateRentDate() {
			const hasNoDate = !this.rent.date;

			if (hasNoDate) {
				this.errors.push('A date for the rent must be provided.');
			}

			const rentIsOutDated = this.$date.isOutDated(this.rent.date);

			if (!hasNoDate && rentIsOutDated) {
				this.errors.push(
					'The rent cannot be assigned for a passed date.'
				);
			}

			this.isValid = this.isValid && !hasNoDate && !rentIsOutDated;
		},
		validateReturnDate() {
			const hasNoDate = !this.rent.returnDate;
			let isValid = true;

			if (hasNoDate) {
				isValid = false;

				this.errors.push('A return date must be provided.');
			} else {
				const { returnDate, date } = this.rent;
				const returnDateIsOutDated = this.$date.isOutDated(returnDate);

				if (returnDateIsOutDated) {
					this.errors.push(
						'The return date cannot be assigned for a passed date.'
					);
				}

				const returnDateIsInvalid = returnDate < date;

				if (returnDateIsInvalid) {
					this.errors.push(
						'The return date cannot be before the rent date.'
					);
				}

				isValid = !returnDateIsOutDated && !returnDateIsInvalid;
			}

			this.isValid = this.isValid && isValid;
		},
		notifyErrors() {
			this.$notifications.notify({
				message: this.$formsValidator.getErrorListAsHTML(this.errors),
				type: 'danger',
				verticalAlign: 'bottom',
				horizontalAlign: 'right',
				icon: 'fa fa-warning'
			});
		},
		save() {
			const body = {
				vehicle_id: this.inspection.vehicle_id,
				client_id: this.inspection.client_id,
				rent_date: this.rent.date,
				return_date: this.rent.returnDate,
				daily_fee: this.rent.dailyFair,
				employee_id: this.employeeId,
				comment: this.rent.comment
			};

			this.isCreatingRent = true;

			this.$axios
				.post('/api/rents', body)
				.then(resp => {
					this.inspection.rent_id = resp.data.id;

					return this.$axios
						.post('/api/inspections', this.inspection)
						.then(res => {
							const eventToEmit = 'rent-created';
							this.isCreatingRent = false;
							this.clearForm();
							this.$storage.removeItem(RENT_INSPECTION);
							this.$emit(eventToEmit, resp.data);
						})
						.catch(this.throwError.bind(this));
				})
				.catch(this.throwError.bind(this));
		},
		clearForm() {
			this.rent = this.createInitialRent();
		},
		throwError(error) {
			this.isValid = false;
			this.isCreatingRent = false;
			const errors = error.response.data.errors || [
				error.response.data.message
			];
			this.errors.push(Object.values(errors).map(error => error[0]));
			this.notifyErrors();
		},
		createInitialRent() {
			return {
				vehicleId: null,
				clientId: null,
				dailyFair: 0.0,
				date: null,
				returnDate: null,
				comment: ''
			};
		}
	}
};
</script>