import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://localhost:1000',
    withCredentials: true,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
});

export default instance;
