// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import fusion from './vendor/nitro/fusion/js/vite.js';

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/js/app.js'], refresh: true }),
        fusion(),
        svelte(),
    ],
});

// resources/js/app.js
import { fusionSvelte } from 'nitro-fusion/svelte';

fusionSvelte(import.meta.glob(['../views/svelte/**/*.svelte', './svelte/**/*.svelte']));
