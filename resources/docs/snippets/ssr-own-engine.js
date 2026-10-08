// resources/js/ssr.js: a renderer for a view engine of your own
import { serve } from 'nitro-fusion/ssr';
import { renderToString } from 'my-framework/server';

const views = import.meta.glob('../views/mine/**/*.mine', { eager: true });

serve({
    mine: {
        /** The view's name, and the component as the browser's first render reads it: handle.get('title'). */
        async render(view, handle) {
            const module = Object.entries(views).find(([path]) => path.endsWith(`/${view}.mine`))?.[1];
            return renderToString(module.default, { get: handle.get, errors: handle.errors() });
        },
    },
});
