import formUtils from '../utils/form.utils';

export default {
    create({ object, index, props = {} }) {
        return {
            ...object,
            ...props,
            ord: index + 1
        };
    },
    createForTableList({ object, index, onEdit, onRemove }) {
        const obj = this.create({ object, index });
        return formUtils.addActionsTo(obj, onEdit, onRemove);
    }
};