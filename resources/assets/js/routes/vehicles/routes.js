import VehicleTypes from '../../components/Dashboard/Vehicles/VehicleTypes.vue';
import VehicleBrands from '../../components/Dashboard/Vehicles/VehicleBrands.vue';
import VehicleModels from '../../components/Dashboard/Vehicles/VehicleModels.vue';
import VehicleFuels from '../../components/Dashboard/Vehicles/VehicleFuels.vue';

export default [{
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
    }
];