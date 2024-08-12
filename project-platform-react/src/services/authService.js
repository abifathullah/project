import axios from '../axios'; // Import your configured axios instance

const login = (email, password) => {
    return axios.post('/login', { email, password });
};

const logout = () => {
    return axios.post('/logout');
};

const getCurrentUser = () => {
    return axios.get('/users');
};

const authService = {
    login,
    logout,
    getCurrentUser,
};

export default authService;
