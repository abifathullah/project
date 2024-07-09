import { defineStore } from 'pinia';
import { version as vueVersion } from 'vue';

import axios from '@/axios';

export const useVersionsStore = defineStore('versions', {
    state: () => ({
        phpVersion: '',
        laravelVersion: '',
        vueVersion,
    }),

    actions: {
        async fetchVersions() {
            try {
                const response = await axios.get('/api/versions/base');
                this.phpVersion = response.data.php_version;
                this.laravelVersion = response.data.laravel_version;
            } catch (error) {
                console.error('Error fetching versions:', error);
            }
        },
    },
});
