import axios from 'axios';

const API_URL = 'http://localhost:1000/api/products';

// If using tokens (e.g., Bearer token)
const user = JSON.parse(localStorage.getItem('user')); // Parse the stored user object
const token = user ? user.token : null; // Extract the token

axios.defaults.headers.common['Authorization'] = token ? `Bearer ${token}` : ''; // Set the Authorization header

axios.defaults.withCredentials = true;

const getProducts = () => {
    return axios.get(API_URL);
};

const createProduct = (product) => {
    return axios.post(API_URL, product);
};

const updateProduct = (id, product) => {
    return axios.put(`${API_URL}/${id}`, product);
};

const deleteProduct = (id) => {
    return axios.delete(`${API_URL}/${id}`);
};

const productService = {
    getProducts,
    createProduct,
    updateProduct,
    deleteProduct,
};

export default productService;
