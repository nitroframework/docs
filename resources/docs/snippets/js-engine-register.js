// resources/js/app.js, loaded before @nitroScripts
const charts = import.meta.glob('./charts/*.js');

document.addEventListener('nitro:starting', ({ detail: { Nitro } }) => {
    Nitro.engine('chart', {
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
