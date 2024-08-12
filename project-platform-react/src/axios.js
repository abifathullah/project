import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: 'http://localhost:1000/api', // Ensure this points to port 1000
});

// Function to get the token from localStorage
const getToken = () => {
    const user = localStorage.getItem('user');
    try {
        return user ? JSON.parse(user).token : null;
    } catch (error) {
        console.error("Failed to parse user data from localStorage", error);
        return null;
    }
};

// Add a request interceptor to include the Bearer token
axiosInstance.interceptors.request.use((config) => {
    const token = getToken();
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, (error) => {
    return Promise.reject(error);
});

// Add a response interceptor to handle errors
axiosInstance.interceptors.response.use(
    response => response,
    error => {
        console.error('API Error:', error.response ? error.response.data : error.message);
        return Promise.reject(error);
    }
);

export default axiosInstance;
