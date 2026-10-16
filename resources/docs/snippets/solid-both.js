// vite.config.js: each plugin compiles its own folders' files
import nitro, { only } from './vendor/nitro/nitro/js/vite.js';

plugins: [
    laravel({ input: ['resources/js/app.js'], refresh: true }),
    nitro(),
    react({ include: only('react') }),
    solid({ include: only('solid') }),
],
