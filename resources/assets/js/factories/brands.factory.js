import formUtils from '../utils/form.utils';

export default {
    createBrandForTableList({brand, index, onEdit, onRemove}) {
        const vehicleBrand = this.createBrand({brand, index});
        return formUtils.addActionsTo(vehicleBrand, onEdit, onRemove);
    },
    createBrand({brand, index, props = {}}) {
        return Object.assign(brand, {ord: index + 1}, props);
    }
};