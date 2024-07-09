import axios from 'axios';

const authService = {
    setAuthorizationToken(token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },

    removeAuthorizationToken() {
        delete axios.defaults.headers.common['Authorization'];
    }
};

export default authService;
