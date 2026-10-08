// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import solid from 'vite-plugin-solid';
import fusion from './vendor/nitro/fusion/js/vite.js';

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/js/app.js'], refresh: true }),
        fusion(),
        solid(),
    ],
});

// resources/js/app.js
import { fusionSolid } from 'nitro-fusion/solid';

fusionSolid(import.meta.glob(['../views/solid/**/*.{jsx,tsx}', './solid/**/*.{jsx,tsx}']));
