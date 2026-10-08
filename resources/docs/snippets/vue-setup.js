// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import fusion from './vendor/nitro/fusion/js/vite.js';

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/js/app.js'], refresh: true }),
        fusion(),
        vue(),
    ],
});

// resources/js/app.js
import { fusionVue } from 'nitro-fusion/vue';

fusionVue(import.meta.glob(['../views/vue/**/*.vue', './vue/**/*.vue']));
