// vite.config.js: each plugin compiles its own folder's .jsx
plugins: [
    laravel({ input: ['resources/js/app.js'], refresh: true }),
    nitro(),
    react({ include: /resources[\\/](views|js)[\\/]react[\\/].*\.[jt]sx$/ }),
    solid({ include: /resources[\\/](views|js)[\\/]solid[\\/].*\.[jt]sx$/ }),
],
