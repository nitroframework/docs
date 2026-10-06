Fusion.directive('sortable', ({ el, component }) => {
    const list = makeSortable(el, {
        onEnd: (ids) => component.dispatch('reordered', ids),
    });

    return () => list.destroy();
});
