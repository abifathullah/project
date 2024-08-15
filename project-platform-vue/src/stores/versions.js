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
                const { data } = await axios.get('/api/versions/base');
                this.phpVersion = data.php_version;
                this.laravelVersion = data.laravel_version;
            } catch (error) {
                console.error('Error fetching versions:', error);
            }
        },
    },
});
