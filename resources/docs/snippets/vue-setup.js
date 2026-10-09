// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import nitro from './vendor/nitro/nitro/js/vite.js';

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/js/app.js'], refresh: true }),
        nitro(),
        vue(),
    ],
});

// resources/js/app.js
import { nitroVue } from 'nitro/vue';

nitroVue(import.meta.glob(['../views/vue/**/*.vue', './vue/**/*.vue']));
