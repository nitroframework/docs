import { createPinia } from 'pinia';
import { createI18n } from 'vue-i18n';
import { nitroVue } from 'nitro/vue';
import messages from './lang/messages.js';

/** One Pinia for every view on the page, so their stores are shared. */
const pinia = createPinia();
const i18n = createI18n({ locale: document.documentElement.lang, messages });

nitroVue(import.meta.glob(['../views/vue/**/*.vue', './vue/**/*.vue']), {
    /** Called for each view's app before it mounts: the plugins it uses. */
    setup(app) {
        app.use(pinia);
        app.use(i18n);
    },
});
