// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import fusion from './vendor/nitro/fusion/js/vite.js';

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/js/app.js'], refresh: true }),
        fusion(),
        react(),
    ],
});

// resources/js/app.js
import { fusionReact } from 'nitro-fusion/react';

fusionReact(import.meta.glob(['../views/react/**/*.{jsx,tsx}', './react/**/*.{jsx,tsx}']));
