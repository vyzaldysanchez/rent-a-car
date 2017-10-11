export default {
    create({object, index, props = {}}) {
        return Object.assign(object, {ord: index + 1}, props);
    }
};