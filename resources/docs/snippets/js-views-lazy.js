// resources/js/app.js
import { lazy } from 'nitro/lazy';

lazy('vue', () => import('nitro/vue'), import.meta.glob('../views/vue/**/*.vue'));
lazy('react', () => import('nitro/react'), import.meta.glob('../views/react/**/*.jsx'));
lazy('solid', () => import('nitro/solid'), import.meta.glob('../views/solid/**/*.jsx'));
lazy('svelte', () => import('nitro/svelte'), import.meta.glob('../views/svelte/**/*.svelte'));

// The adapter's options come last: { setup } for Vue, { wrap } for React.
lazy('vue', () => import('nitro/vue'), import.meta.glob('../views/vue/**/*.vue'), {
    setup: (app) => app.use(i18n),
});
