// resources/js/libraries.js: your layout loads it, with the libraries
const bindings = (Nitro) => {
    Nitro.directive('select2', ({ el, value, component }) => {
        const $el = $(el);

        // 1. Start it with the property's value.
        $el.val(component.get(value)).select2();

        // 2. The visitor chose: set the property.
        $el.on('change.nitro', () => component.set(value, $el.val()));

        // 3. Anything else changed the property: show it (the namespaced event tells select2 only).
        const stop = component.watch(value, (now) => $el.val(now).trigger('change.select2'));

        // 4. Leaving the page, an @if, a removed row: tear it down.
        return () => {
            stop();
            $el.off('change.nitro').select2('destroy');
        };
    });

    // ... the other libraries' bindings
};

// Loaded before Nitro (a page's first load): when it starts. Loaded by a visit, after it: now.
if (window.Nitro) bindings(window.Nitro);
else document.addEventListener('nitro:init', ({ detail: { Nitro } }) => bindings(Nitro));
