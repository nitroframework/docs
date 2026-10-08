// resources/js/ssr.js
import { serve } from 'nitro-fusion/ssr';
import { renderVue } from 'nitro-fusion/vue/server';
import { renderReact } from 'nitro-fusion/react/server';
import { renderSolid } from 'nitro-fusion/solid/server';
import { renderSvelte } from 'nitro-fusion/svelte/server';

/** A renderer for each framework the app's views use; leave out the ones it doesn't. */
serve({
    vue: renderVue(import.meta.glob(['../views/vue/**/*.vue', './vue/**/*.vue'], { eager: true })),
    react: renderReact(import.meta.glob(['../views/react/**/*.{jsx,tsx}', './react/**/*.{jsx,tsx}'], { eager: true })),
    solid: renderSolid(import.meta.glob(['../views/solid/**/*.{jsx,tsx}', './solid/**/*.{jsx,tsx}'], { eager: true })),
    svelte: renderSvelte(import.meta.glob(['../views/svelte/**/*.svelte', './svelte/**/*.svelte'], { eager: true })),
});
