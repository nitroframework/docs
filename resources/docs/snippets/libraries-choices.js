Nitro.directive('choices', ({ el, value, component }) => {
    const choices = new Choices(el, { shouldSort: false });
    choices.setChoiceByValue(component.get(value));
    const changed = () => component.set(value, choices.getValue(true));
    el.addEventListener('change', changed);
    const stop = component.watch(value, (now) => choices.setChoiceByValue(now));

    return () => {
        stop();
        el.removeEventListener('change', changed);
        choices.destroy();
    };
});
