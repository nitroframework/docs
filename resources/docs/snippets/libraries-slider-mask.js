Nitro.directive('slider', ({ el, value, component }) => {
    noUiSlider.create(el, { start: component.get(value), step: 1, range: { min: 0, max: 100 } });
    el.noUiSlider.on('set', ([now]) => Number(now) !== component.get(value) && component.set(value, Math.round(Number(now))));
    const stop = component.watch(value, (now) => el.noUiSlider.set(now));

    return () => {
        stop();
        el.noUiSlider.destroy();
    };
});

Nitro.directive('mask', ({ el, value, component }) => {
    const mask = IMask(el, { mask: '0000 0000 0000 0000' });
    mask.unmaskedValue = component.get(value) ?? '';          // the property holds the digits
    mask.on('accept', () => mask.unmaskedValue !== component.get(value) && component.set(value, mask.unmaskedValue));
    const stop = component.watch(value, (now) => { mask.unmaskedValue = now ?? ''; });

    return () => {
        stop();
        mask.destroy();
    };
});
