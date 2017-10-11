import formUtils from '../utils/form.utils';

export default {
    create({object, index, props = {}}) {
        return Object.assign(object, {ord: index + 1}, props);
    },
    createForTableList({object, index, onEdit, onRemove}) {
        const obj = this.create({object, index});
        return formUtils.addActionsTo(obj, onEdit, onRemove);
    }
};