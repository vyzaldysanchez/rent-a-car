export default {
	getTodayDate() {
		return new Date();
	},
	getTodayDateAsISO() {
        return this.getTodayDate().toISOString().substring(0, 10);
	},
	isOutDated(isoDate) {
		return this.getTodayDateAsISO() > isoDate;
	}
};
