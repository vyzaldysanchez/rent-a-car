<template>
    <div class="vehicle-inspection-form">
        <form>
            <div class="form-group col-md-5 col-md-offset-1">
                <fg-select label="Vehicle to inspect" placeholder="Select the vehicle to inspect..." :options="vehiclesToSelect"
                    v-model="vehicleId" @change="updateVehicle"></fg-select>
            </div>

            <div class="form-group col-md-5">
                <fg-select label="Client who wants to rent" placeholder="Select the client..." :options="clientsToSelect"
                    v-model="clientId" @change="updateClient"></fg-select>
            </div>

            <div class="form-group col-md-5 col-md-offset-1">
				<fg-check label="Scratches?" v-model="isScratched" id="scratches" name="scratches"
					@change="isScratched = $event"></fg-check>

				<fg-check label="Spare Tire?" v-model="hasSpareTire" id="spare-tire" name="spare-tire"
					@change="hasSpareTire = $event"></fg-check>
				
				<fg-check label="Jack?" v-model="hasJack" id="jack" name="jack"
					@change="hasJack = $event"></fg-check>
				
				<fg-check label="Glasses Broken?" v-model="hasBrokenGlasses" id="glass-broken" name="glass-broken"
					@change="hasBrokenGlasses = $event"></fg-check>
            </div>

            <div class="form-group col-md-5">
                <fg-range label="Fuel level (0%, 25%, 50%, 75%, 100%)" v-model="fuelLevel" type="range" list="fuel-range" 
                    :step=".25" :list-values="range" :min="range[0].value" :max="range[4].value"></fg-range>
            </div>

			<div class="form-group col-md-10 col-md-offset-1">
				<div class="col-md-6">	
					<fg-select label="Top left tire state" placeholder="Select the state..." :options="wheelsStateList"
						v-model="topLeftTire" @change="updateTire('topLeftTire', $event)"></fg-select>
						
					<fg-select label="Bottom left tire state" placeholder="Select the state..." :options="wheelsStateList"
						v-model="bottomLeftTire" @change="updateTire('bottomLeftTire', $event)"></fg-select>
				</div>
					
				<div class="col-md-6">	
					<fg-select label="Top right tire state" placeholder="Select the state..." :options="wheelsStateList"
						v-model="topRightTire" @change="updateTire('topRightTire', $event)"></fg-select>
						
					<fg-select label="Bottom right tire state" placeholder="Select the state..." :options="wheelsStateList"
						v-model="bottomRightTire" @change="updateTire('bottomRightTire', $event)"></fg-select>
				</div>
			</div>

			<div class="col-md-12 form-group">
        	    <button type="button" class="btn btn-primary btn-fill center-block" :class="{'disabled': isCreatingInspection}"
                     @click.prevent="validBeforeSave">
					 	Continue with the rent		
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import fgSelectHelper from './../../../UIComponents/Inputs/Helpers/fg-select.helper';
import { RENT_INSPECTION } from './../../../../utils/form.utils';

const rangeList = [
	{ value: 0, label: 'Empty' },
	{ value: 0.25, label: '1/4' },
	{ value: 0.5, label: '2/4' },
	{ value: 0.75, label: '3/4' },
	{ value: 1, label: 'Full' }
];

const wheelsStateList = [
	{ value: 'new', label: 'New' },
	{ value: 'used', label: 'Used' },
	{ value: 'wasted', label: 'Wasted' }
];

export default {
	props: {
		vehicles: { type: Array, default: Array, required: true },
		clients: { type: Array, default: Array, required: true },
		user: { type: Object, default: Object, required: true }
	},
	data() {
		return {
			clientId: 0,
			vehicleId: 0,
			isScratched: false,
			hasSpareTire: false,
			hasJack: false,
			hasBrokenGlasses: false,
			fuelLevel: 0,
			bottomLeftTire: '',
			bottomRightTire: '',
			topLeftTire: '',
			topRightTire: '',
			isCreatingInspection: false,
			isFormValid: false,
			error: []
		};
	},
	computed: {
		range() {
			return rangeList;
		},
		vehiclesToSelect() {
			return fgSelectHelper.mapToSelectListItem(this.vehicles, [
				'id',
				'description'
			]);
		},
		clientsToSelect() {
			return fgSelectHelper.mapToSelectListItem(this.clients, [
				'id',
				'name'
			]);
		},
		wheelsStateList() {
			return wheelsStateList;
		}
	},
	methods: {
		updateVehicle(vehicleId) {
			this.vehicleId = vehicleId;
		},
		updateClient(clientId) {
			this.clientId = clientId;
		},
		updateTire(tireName, value) {
			this[tireName] = value;
		},
		validBeforeSave() {
			this.errors = [];
			this.isFormValid = true;

			this.validate();

			if (this.isFormValid) {
				this.$swal({
					title: 'Are you sure?',
					html: `The inspection will be stored and performed when the rent is finished!.`,
					type: 'warning',
					showConfirmButton: true,
					showCancelButton: true
				}).then(this.save.bind(this));
			} else {
				this.notifyErrors();
			}
		},
		validate() {
			this.validateVehicle();
			this.validateClient();
			this.validateTires();
		},
		validateVehicle() {
			const isValid = !!this.vehicleId;

			if (!isValid) {
				this.errors.push('Must select a vehicle!');
			}

			this.isFormValid = this.isFormValid && isValid;
		},
		validateClient() {
			const isValid = !!this.clientId;

			if (!isValid) {
				this.errors.push('Must select a client!');
			}

			this.isFormValid = this.isFormValid && isValid;
		},
		validateTires() {
			const isTopLeftValid = !!this.topLeftTire;
			const isTopRightValid = !!this.topRightTire;
			const isBottomLeftValid = !!this.bottomLeftTire;
			const isBottomRightValid = !!this.bottomRightTire;

			const isTopValid = isTopLeftValid && isTopRightValid;
			const isBottomValid = isBottomLeftValid && isBottomRightValid;

			if (!isTopValid || !isBottomValid) {
				this.errors.push('Must set the tires state!');
			}

			this.isFormValid = this.isFormValid && isTopValid && isBottomValid;
		},
		save() {
			const body = {
				has_scratches: this.isScratched,
				has_spare_tire: this.hasSpareTire,
				has_jack: this.hasJack,
				has_broken_glasses: this.hasBrokenGlasses,
				fuel_qty: this.fuelLevel,
				top_left_tire_state: this.topLeftTire,
				top_right_tire_state: this.topRightTire,
				bottom_left_tire_state: this.bottomLeftTire,
				bottom_right_tire_state: this.bottomRightTire,
				client_id: this.clientId,
				employee_id: this.user.employeeId,
				vehicle_id: this.vehicleId,
				rent_id: 0
			};

			this.isCreatingInspection = true;

			this.$storage
				.setItem(RENT_INSPECTION, body)
				.then(() =>
					this.$router.push({ path: '/admin/vehicles/rent' })
				);
		},
		notifyErrors() {
			this.$notifications.notify({
				message: this.$formsValidator.getErrorListAsHTML(this.errors),
				type: 'danger',
				verticalAlign: 'bottom',
				horizontalAlign: 'right',
				icon: 'fa fa-warning'
			});
		}
	}
};
</script>	 
