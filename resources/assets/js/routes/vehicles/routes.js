import VehicleTypes from '../../components/Dashboard/Vehicles/VehicleTypes.vue'

export default {
    path: 'vehicles',
    component: null,
    children: [
        {
            path: 'types',
            name: 'vehicle-types',
            component: VehicleTypes
        }
    ]
};