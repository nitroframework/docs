// vite.config.js: Solid compiles views to hydrate, for the browser and for the render service
solid({ ssr: true }),

// resources/js/ssr.js
import { serve } from 'nitro/ssr';
import { renderSolid } from 'nitro/solid/server';

serve({
    solid: renderSolid(import.meta.glob(['../views/solid/**/*.{jsx,tsx}', './solid/**/*.{jsx,tsx}'], { eager: true })),
});
