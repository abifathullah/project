<template>
    <v-alert v-if="error" type="error" dismissible class="error-alert" @input="clearError">
        {{ error }}
    </v-alert>
</template>

<script>
import { error, clearError } from '@/services/errorHandler';

export default {
    setup() {
        return {
            error,
            clearError,
        };
    },
};
</script>

<style scoped>
.error-alert {
    margin: 20px;
    font-size: 16px;
}
</style>
