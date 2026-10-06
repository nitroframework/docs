// resources/js/app.js, loaded before @fusionScripts
document.addEventListener('fusion:starting', ({ detail: { Fusion } }) => {
    Fusion.directive('autosize', autosize);    // Before any component starts.
    Fusion.use(analytics);
});
