Nitro.directive('tom-select', ({ el, value, component }) => {
    const select = new TomSelect(el, {});
    select.setValue(component.get(value), true);                       // true: silent
    select.on('change', (now) => component.set(value, now));
    const stop = component.watch(value, (now) => select.setValue(now, true));

    return () => {
        stop();
        select.destroy();
    };
});
