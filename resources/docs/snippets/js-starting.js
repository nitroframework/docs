// resources/js/app.js, loaded before @nitroScripts
document.addEventListener('nitro:init', ({ detail: { Nitro } }) => {
    Nitro.directive('autosize', autosize);    // Before any component starts.
    Nitro.use(analytics);
});
