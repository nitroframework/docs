// <div nitro:ignore><ul nitro:sortable="order"></ul></div>: the list is drawn here, from the property
Nitro.directive('sortable', ({ el, value, component }) => {
    el.innerHTML = component.get(value).map((id) => `<li data-id="${id}">${id}</li>`).join('');
    const sortable = Sortable.create(el, { onEnd: () => component.set(value, sortable.toArray()) });
    const stop = component.watch(value, (order) => sortable.sort(order, false));

    return () => {
        stop();
        sortable.destroy();
    };
});
