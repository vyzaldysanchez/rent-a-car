export default {
    addActionsTo(object, onEdit, onDelete) {
        return {
            ...object,
            actions: [
                {
                    click: () => onEdit(object),
                    classes: 'text-warning',
                    text: '<i class="fa fa-edit"></i>'
                },
                {
                    click: () => onDelete(object),
                    classes: 'text-danger',
                    text: '<i class="fa fa-remove"></i>'
                }
            ]
        };
    }
};