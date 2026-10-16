import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import react from '@vitejs/plugin-react';
import solid from 'vite-plugin-solid';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import nitro, { only } from './vendor/nitro/nitro/js/vite.js';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        /** The examples' Vue, React, Solid and Svelte views: Nitro's adapters, one copy of each framework. */
        nitro(),
        vue(),
        svelte(),
        /** React and Solid both write .jsx: each compiles its own folder's. */
        react({ include: only('react') }),
        solid({ include: only('solid') }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
