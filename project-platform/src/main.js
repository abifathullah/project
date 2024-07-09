import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import vuetify from './plugins/vuetify';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import axios from 'axios';
import Cookies from 'js-cookie';
import { handleApiError } from '@/services/errorHandler';

const app = createApp(App);

// Configure Axios
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:1000';

axios.interceptors.request.use(async (config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    if (!Cookies.get('XSRF-TOKEN')) {
        await axios.get('/sanctum/csrf-cookie');
    }
    config.headers['X-XSRF-TOKEN'] = Cookies.get('XSRF-TOKEN');
    return config;
});

axios.interceptors.response.use(
    (response) => response,
    (error) => {
        console.error('Axios error:', error);
        handleApiError(
            error.response || { data: { message: 'Network error. Please check your connection.' } }
        );

        if (error.response && error.response.status === 401) {
            localStorage.removeItem('token');
            router.push({ name: 'Login' });
        }
        return Promise.reject(error);
    }
);

app.use(createPinia());
app.use(router);
app.use(Toast);
app.use(vuetify);

app.mount('#app');
