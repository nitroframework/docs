Nitro.directive('flatpickr', ({ el, value, component }) => {
    const picker = flatpickr(el, {
        dateFormat: 'Y-m-d',
        defaultDate: component.get(value),
        onChange: (dates, text) => component.set(value, text),
    });
    const stop = component.watch(value, (now) => picker.setDate(now, false));   // false: no onChange

    return () => {
        stop();
        picker.destroy();
    };
});
