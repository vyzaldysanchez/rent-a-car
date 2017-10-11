import formUtils from '../utils/form.utils';
import factory from './factory';

export default {
    createModelForTableList({model, brand, index, onEdit, onRemove}) {
        const vehicleModel = factory.create({object: model, index});

        vehicleModel.brand = brand ? brand.description : '';
        vehicleModel.brandId = brand.id ? brand.id : null;

        return formUtils.addActionsTo(vehicleModel, onEdit, onRemove);
    },
    factory
};