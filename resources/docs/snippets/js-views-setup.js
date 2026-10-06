// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import react from '@vitejs/plugin-react';
import solid from 'vite-plugin-solid';
import fusion from './vendor/nitro/fusion/js/vite.js';

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/js/app.js'], refresh: true }),
        fusion(),
        vue(),
        // React and Solid both compile .jsx: give each its own folders.
        react({ include: /resources[\\/](views|js)[\\/]react[\\/].*\.jsx$/ }),
        solid({ include: /resources[\\/](views|js)[\\/]solid[\\/].*\.jsx$/ }),
    ],
});

// resources/js/app.js
import { fusionVue } from 'nitro-fusion/vue';
import { fusionReact } from 'nitro-fusion/react';
import { fusionSolid } from 'nitro-fusion/solid';

fusionVue(import.meta.glob(['../views/vue/**/*.vue', './vue/**/*.vue']));
fusionReact(import.meta.glob(['../views/react/**/*.jsx', './react/**/*.jsx']));
fusionSolid(import.meta.glob(['../views/solid/**/*.jsx', './solid/**/*.jsx']));
