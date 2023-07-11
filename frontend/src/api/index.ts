import axios from 'axios';

const instance = axios.create({
    baseURL: process.env.VUE_APP_API_BASE_URL,
});

instance.interceptors.response.use(
    (response) => response,
    (error) => {
        const errorCode = error.response?.status || 'UNKNOWN';
        const errorMessage = error.response?.data?.message || 'UNKNOWN';
        const keys = Object.keys(error.response.data.errors);
        const firstError = error.response.data.errors[keys[0]][0];
        alert('Server error: ' + firstError)

        console.error(`error ${errorCode} ${errorMessage}`);

        return Promise.reject(error);
    },
);

export default instance;

