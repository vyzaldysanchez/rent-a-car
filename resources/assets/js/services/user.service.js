import axios from 'axios'
import userFactory from '../factories/user.factory'
import * as localforage from 'localforage'

export const AUTH_USER_KEY = 'auth-user';

export default {
    login(user = {email: '', password: ''}) {
        return axios.post('http://localhost:8000/api/auth/login/', user)
            .then(this.setUserFromResponse);
    },
    logout() {
        return axios.post('http://localhost:8000/api/auth/logout/')
            .then(this.removeCurrentUserFromMemory);
    },
    setUserFromResponse(response) {
        return localforage.setItem(
            AUTH_USER_KEY,
            userFactory.createUserFromHTTP(response)
        );
    },
    removeCurrentUserFromMemory() {
        return localforage.removeItem(AUTH_USER_KEY);
    }
};