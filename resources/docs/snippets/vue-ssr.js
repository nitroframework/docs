// resources/js/ssr.js
import { createPinia } from 'pinia';
import { serve } from 'nitro-fusion/ssr';
import { renderVue } from 'nitro-fusion/vue/server';

serve({
    vue: renderVue(import.meta.glob(['../views/vue/**/*.vue', './vue/**/*.vue'], { eager: true }), {
        /** Called for each render: the service renders for every visitor, so nothing is shared between them. */
        setup(app) {
            app.use(createPinia());
        },
    }),
});
