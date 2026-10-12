// resources/js/app.js
import NProgress from 'nprogress';

// A visit from a link or Nitro.visit(); back and forward come back to a page already seen.
Nitro.hook('beforeNavigate', ({ history }) => history || NProgress.start());
// Over: shown, or stopped, or replaced by another visit.
Nitro.hook('afterNavigate', () => NProgress.done());
