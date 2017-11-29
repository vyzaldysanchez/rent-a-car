<template>
  <div id="rents-form">
    <h2 class="title text-center">Rent a car! <i class="ti-car"></i></h2>

    <hr />

    <form>
      <div class="col-md-6 form-group">
        <fg-select :options="vehicles" id="vehicle" name="vehicle" label="Vehicle to rent" placeholder="Select the vehicle to rent" v-model="rent.vehicleId" @change="selectVehicle"></fg-select>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-select :options="clients" id="client" name="client" label="Client who rents" placeholder="Select the client to rent the car" v-model="rent.clientId" @change="selectClient"></fg-select>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="date" id="rentDate" name="rentDate" label="Rent date" v-model="rent.date"></fg-input>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="date" id="returnDate" name="returnDate" label="Return date" v-model="rent.returnDate"></fg-input>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="number" id="fair" name="fair" label="Daily fair" v-model="rent.dailyFair" :min="0.00"></fg-input>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="number" id="days" name="days" label="Rent days" v-model="rent.rentDays" :min="1"></fg-input>
      </div>
      
      <div class="col-md-12 form-group">
        <fg-textarea label="Comment" id="comment" name="comment" v-model="rent.comment"></fg-textarea>
      </div>

      <div class="form-group">
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
import fgSelectHelper from './../../../UIComponents/Inputs/Helpers/fg-select.helper';
import { AUTH_USER_KEY } from '../../../../services/user.service';

export default {
	data() {
		return {
			rent: this.createInitialRent(),
			vehicles: [],
			clients: [],
			isValid: false,
			errors: [],
			isCreatingRent: false,
			employeeId: 0
		};
	},
	created() {
		this.getFormDataRequest().then(res => {
			const [vehicles, clients, user] = res;

			this.employeeId = user.employeeId;
			this.vehicles = fgSelectHelper.mapToSelectListItem(vehicles.data, [
				'id',
				'description'
			]);
			this.clients = fgSelectHelper.mapToSelectListItem(clients.data, [
				'id',
				'name'
			]);

			this.$emit('loaded');
		});
	},
	methods: {
		getFormDataRequest() {
			return Promise.all([
				this.$axios.get('http://localhost:8000/api/vehicles/available'),
				this.$axios.get('http://localhost:8000/api/clients'),
				this.$storage.getItem(AUTH_USER_KEY)
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

			this.validateSelectedVehicle();
			this.validateSelectedClient();
			this.validateDailyFair();
			this.validateRentDays();
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
		validateSelectedVehicle() {
			if (!this.rent.vehicleId) {
				this.errors.push('You must select a vehicle.');
			}

			this.isValid = this.isValid && this.rent.vehicleId > 0;
		},
		validateSelectedClient() {
			if (!this.rent.clientId) {
				this.errors.push('A client must be selected.');
			}

			this.isValid = this.isValid && this.rent.clientId > 0;
		},
		validateDailyFair() {
			if (!this.rent.dailyFair) {
				this.errors.push('Must define a fair to be charged daily.');
			}

			this.isValid = this.isValid && this.rent.dailyFair > 0;
		},
		validateRentDays() {
			if (!this.rent.rentDays) {
				this.errors.push('An amount of days must be set for the rent.');
			}

			this.isValid = this.isValid && this.rent.rentDays > 0;
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
				vehicle_id: this.rent.vehicleId,
				client_id: this.rent.clientId,
				rent_date: this.rent.date,
				return_date: this.rent.returnDate,
				daily_fee: this.rent.dailyFair,
				duration_in_days: this.rent.rentDays,
				employee_id: this.rent.employeeId,
				comment: this.rent.comment
			};

			this.isCreatingRent = true;

			this.$axios
				.post('http://localhost:8000/api/rents', body)
				.then(resp => {
					const eventToEmit = 'rent-created';
					this.isCreatingRent = false;
					this.clearForm();
					this.$emit(eventToEmit, resp.data);
				})
				.catch(error => {
					this.isValid = false;
					this.isCreatingRent = false;
					const errors = error.response.data.errors || [
						error.response.data.message
					];
					this.errors.push(
						Object.values(errors).map(error => error[0])
					);
					this.notifyErrors();
				});
		},
		clearForm() {
			this.employee = this.createInitialRent();
			this.passwordConfirmation = '';
			this.activateCredentials = false;
			this.onEditionMode = false;
		},
		createInitialRent() {
			return {
				vehicleId: null,
				clientId: null,
				dailyFair: 0.0,
				rentDays: 1,
				date: null,
				returnDate: null,
				comment: ''
			};
		}
	}
};
</script>