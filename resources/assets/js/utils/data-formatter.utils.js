export default {
    formatIdentification(value) {
        return value
            .replace(/\D+/g, '')
            .replace(/^(\d{3})(\d{7})(\d{1})/, '$1-$2-$3');
    }
};