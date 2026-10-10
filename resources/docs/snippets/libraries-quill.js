Nitro.directive('quill', ({ el, value, component }) => {
    const quill = new Quill(el, { theme: 'snow' });
    const show = (html) => quill.setContents(quill.clipboard.convert({ html: html ?? '' }), 'silent');
    show(component.get(value));
    quill.on('text-change', (delta, old, source) => source === 'user' && component.set(value, quill.root.innerHTML));
    const stop = component.watch(value, show);

    return () => {
        stop();
        el.innerHTML = '';
    };
});
