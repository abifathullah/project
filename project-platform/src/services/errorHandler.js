import { ref } from 'vue';

const error = ref(null);

const handleApiError = (response) => {
    console.error('Handling API error:', response);
    if (
        response &&
        response.data &&
        response.data.message == 'Network error. Please check your connection.'
    ) {
        error.value = response.data.message;
    }
};

const clearError = () => {
    error.value = null;
};

export { error, handleApiError, clearError };
