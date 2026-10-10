// resources/js/app.js
import NProgress from 'nprogress';

window.addEventListener('nitro:navigating', () => NProgress.start());
window.addEventListener('nitro:navigated', () => NProgress.done());
