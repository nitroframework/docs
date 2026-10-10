// <div nitro:ignore><div nitro:trix="body"></div></div>
Nitro.directive('trix', ({ el, value, component }) => {
    const input = Object.assign(document.createElement('input'), { type: 'hidden', id: `trix-${Math.random().toString(36).slice(2)}`, value: component.get(value) ?? '' });
    const editor = document.createElement('trix-editor');
    editor.setAttribute('input', input.id);
    el.append(input, editor);

    let loading = false;
    const changed = () => loading || component.set(value, input.value);
    editor.addEventListener('trix-change', changed);
    const stop = component.watch(value, (now) => {
        loading = true;
        editor.editor.loadHTML(now ?? '');
        loading = false;
    });

    return () => {
        stop();
        editor.removeEventListener('trix-change', changed);
        el.innerHTML = '';
    };
});
