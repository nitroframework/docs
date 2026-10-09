// resources/js/ssr.js
import { serve } from 'nitro/ssr';
import { renderVue } from 'nitro/vue/server';
import { renderReact } from 'nitro/react/server';
import { renderSolid } from 'nitro/solid/server';
import { renderSvelte } from 'nitro/svelte/server';

/** A renderer for each framework the app's views use; leave out the ones it doesn't. */
serve({
    vue: renderVue(import.meta.glob(['../views/vue/**/*.vue', './vue/**/*.vue'], { eager: true })),
    react: renderReact(import.meta.glob(['../views/react/**/*.{jsx,tsx}', './react/**/*.{jsx,tsx}'], { eager: true })),
    solid: renderSolid(import.meta.glob(['../views/solid/**/*.{jsx,tsx}', './solid/**/*.{jsx,tsx}'], { eager: true })),
    svelte: renderSvelte(import.meta.glob(['../views/svelte/**/*.svelte', './svelte/**/*.svelte'], { eager: true })),
});
