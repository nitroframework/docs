// resources/js/app.js, loaded before @fusionScripts
const charts = import.meta.glob('./charts/*.js');

document.addEventListener('fusion:starting', ({ detail: { Fusion } }) => {
    Fusion.engine('chart', {
        load: (view) => charts[`./charts/${view}.js`]().then((module) => module.default),
        mount(draw, el, handle) {
            const chart = draw(el, handle);

            return {
                update: () => chart.redraw(),
                unmount: () => chart.destroy(),
            };
        },
    });
});
