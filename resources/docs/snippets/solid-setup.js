// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import solid from 'vite-plugin-solid';
import nitro from './vendor/nitro/nitro/js/vite.js';

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/js/app.js'], refresh: true }),
        nitro(),
        solid(),
    ],
});

// resources/js/app.js
import { nitroSolid } from 'nitro/solid';

nitroSolid(import.meta.glob(['../views/solid/**/*.{jsx,tsx}', './solid/**/*.{jsx,tsx}']));
