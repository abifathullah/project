import { fileURLToPath, URL } from 'node:url';

import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import vueJsx from '@vitejs/plugin-vue-jsx';

export default defineConfig({
    plugins: [
        vue(),
        vueJsx(),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url))
        }
    },
    optimizeDeps: {
        include: [
            'axios',
            'vue',
            'vue-router',
            'pinia',
            'vuetify',
            'vue-toastification'
        ],
    },
    server: {
        host: '0.0.0.0',
        port: 3000
    },
    root: './',
});
