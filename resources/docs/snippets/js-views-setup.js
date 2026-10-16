// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import react from '@vitejs/plugin-react';
import solid from 'vite-plugin-solid';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import nitro, { only } from './vendor/nitro/nitro/js/vite.js';

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/js/app.js'], refresh: true }),
        nitro(),
        vue(),
        svelte(),
        // React and Solid both compile .jsx: give each its own folders.
        react({ include: only('react') }),
        solid({ include: only('solid') }),
    ],
});

// resources/js/app.js
import { nitroVue } from 'nitro/vue';
import { nitroReact } from 'nitro/react';
import { nitroSolid } from 'nitro/solid';
import { nitroSvelte } from 'nitro/svelte';

nitroVue(import.meta.glob(['../views/vue/**/*.vue', './vue/**/*.vue']));
nitroReact(import.meta.glob(['../views/react/**/*.{jsx,tsx}', './react/**/*.{jsx,tsx}']));
nitroSolid(import.meta.glob(['../views/solid/**/*.{jsx,tsx}', './solid/**/*.{jsx,tsx}']));
nitroSvelte(import.meta.glob(['../views/svelte/**/*.svelte', './svelte/**/*.svelte']));
