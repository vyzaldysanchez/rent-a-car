<template>
    <div class="vehicle-inspection">
        <loading-message v-if="!loaded" :only-icon="true"></loading-message>

        <div v-if="loaded">
            <vehicle-inspection-form :vehicles="vehicles" :clients="clients" :user="user"></vehicle-inspection-form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import VehicleInspectionForm from './Forms/VehicleInspectionForm';
import { AUTH_USER_KEY } from '../../../services/user.service';

export default {
	components: {
		VehicleInspectionForm
	},
	data() {
		return {
			loaded: false,
			vehicles: [],
			clients: [], 
			user: {}
		};
	},
	created() {
		this.getDataPromise().then(axios.spread(this.loadFormData.bind(this)));
	},
	methods: {
		getDataPromise() {
			return axios.all([
				axios.get('/api/vehicles/available'),
				axios.get('/api/clients'),
				this.$storage.getItem(AUTH_USER_KEY)
			]);
		},
		loadFormData(vehicles, clients, user) {
			this.vehicles = vehicles.data || [];
			this.clients = clients.data || [];
			this.user = user;
			this.loaded = true;
		}
	}
};
</script>
