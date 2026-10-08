// resources/js/ssr.js
import { serve } from 'nitro-fusion/ssr';
import { renderSvelte } from 'nitro-fusion/svelte/server';

serve({
    svelte: renderSvelte(import.meta.glob(['../views/svelte/**/*.svelte', './svelte/**/*.svelte'], { eager: true })),
});
