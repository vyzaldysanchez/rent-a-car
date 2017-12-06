import VehicleTypes from '../../components/Dashboard/Vehicles/VehicleTypes.vue';
import VehicleBrands from '../../components/Dashboard/Vehicles/VehicleBrands.vue';
import VehicleModels from '../../components/Dashboard/Vehicles/VehicleModels.vue';
import VehicleFuels from '../../components/Dashboard/Vehicles/VehicleFuels.vue';
import Vehicles from '../../components/Dashboard/Vehicles/Vehicles.vue';
import VehicleRent from '../../components/Dashboard/Vehicles/VehicleRent.vue';
import VehicleRents from '../../components/Dashboard/Vehicles/VehicleRents.vue';
import VehicleInspection from './../../components/Dashboard/Vehicles/VehicleInspection';

export default [
	{
		path: 'vehicles/types',
		name: 'vehicle-types',
		component: VehicleTypes
	},
	{
		path: 'vehicles/brands',
		name: 'vehicle-brands',
		component: VehicleBrands
	},
	{
		path: 'vehicles/models',
		name: 'vehicle-models',
		component: VehicleModels
	},
	{
		path: 'vehicles/fuels',
		name: 'vehicle-fuels',
		component: VehicleFuels
	},
	{
		path: 'vehicles/manage',
		name: 'vehicles',
		component: Vehicles
	},
	{
		path: 'vehicles/inspection',
		name: 'vehicle inspection',
		component: VehicleInspection
	},
	{
		path: 'vehicles/rent',
		name: 'rent',
		component: VehicleRent
	},
	{
		path: 'vehicles/rents',
		name: 'rents',
		component: VehicleRents
	}
];
