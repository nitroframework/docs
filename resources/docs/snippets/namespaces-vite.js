// resources/js/app.js
import { nitroVue, namespaced } from 'nitro/vue';

nitroVue({
    ...import.meta.glob('../views/vue/**/*.vue'),
    ...namespaced('billing', import.meta.glob('../../modules/Billing/resources/views/vue/**/*.vue')),
});
