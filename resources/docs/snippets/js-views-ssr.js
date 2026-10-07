// resources/js/ssr.js
import { serve } from 'nitro-fusion/ssr';
import { renderVue } from 'nitro-fusion/vue/server';
import { renderReact } from 'nitro-fusion/react/server';
import { renderSolid } from 'nitro-fusion/solid/server';

serve({
    vue: renderVue(import.meta.glob(['../views/vue/**/*.vue', './vue/**/*.vue'], { eager: true })),
    react: renderReact(import.meta.glob(['../views/react/**/*.jsx', './react/**/*.jsx'], { eager: true })),
    solid: renderSolid(import.meta.glob(['../views/solid/**/*.jsx', './solid/**/*.jsx'], { eager: true })),
});

// vite.config.js: the SSR entry, and Solid built for both sides
laravel({ input: ['resources/js/app.js'], ssr: 'resources/js/ssr.js', refresh: true }),
solid({ ssr: true, include: /resources[\\/](views|js)[\\/]solid[\\/].*\.jsx$/ }),
