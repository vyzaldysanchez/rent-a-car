import formUtils from '../utils/form.utils';

export default {
    createBrandForTableList({brand, index, onEdit, onRemove}) {
        const {id, description, state} = brand,
            vehicleBrand = {ord: index + 1, id, description, state};

        return formUtils.addActionsTo(vehicleBrand, onEdit, onRemove);
    }
};