export default {
	createUserFromHTTP(response) {
		return {
			email: response.data.email,
			id: response.data.id,
			role: response.data.role,
			name: response.data.name,
			employeeId: response.data.employeeId
		};
	}
};
