// resources/js/app.js, loaded before @nitroScripts
document.addEventListener('nitro:starting', ({ detail: { Nitro } }) => {
    Nitro.directive('autosize', autosize);    // Before any component starts.
    Nitro.use(analytics);
});
