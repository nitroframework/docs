// vite.config.js: Solid compiles views to hydrate, for the browser and for the render service
solid({ ssr: true }),

// resources/js/ssr.js
import { serve } from 'nitro-fusion/ssr';
import { renderSolid } from 'nitro-fusion/solid/server';

serve({
    solid: renderSolid(import.meta.glob(['../views/solid/**/*.{jsx,tsx}', './solid/**/*.{jsx,tsx}'], { eager: true })),
});
