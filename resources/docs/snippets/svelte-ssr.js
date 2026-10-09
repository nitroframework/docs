// resources/js/ssr.js
import { serve } from 'nitro/ssr';
import { renderSvelte } from 'nitro/svelte/server';

serve({
    svelte: renderSvelte(import.meta.glob(['../views/svelte/**/*.svelte', './svelte/**/*.svelte'], { eager: true })),
});
