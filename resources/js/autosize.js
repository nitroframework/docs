/**
 * nitro:autosize: a textarea that grows with its text. Its value is the most lines it grows to,
 * nitro:autosize="8"; past that, it scrolls.
 *
 * This file loads before Nitro does, so it registers the directive at nitro:init, before any component starts.
 */
document.addEventListener('nitro:init', ({ detail: { Nitro } }) => {
    Nitro.directive('autosize', ({ el, value }) => {
        const style = getComputedStyle(el);
        const line = parseFloat(style.lineHeight) || 20;
        const padding = parseFloat(style.paddingTop) + parseFloat(style.paddingBottom);
        const max = (Number(value) || Infinity) * line + padding;

        const fit = () => {
            el.style.height = 'auto';
            el.style.height = `${Math.min(el.scrollHeight, max)}px`;
            el.style.overflowY = el.scrollHeight > max ? 'auto' : 'hidden';
        };

        fit();
        el.addEventListener('input', fit);

        return () => el.removeEventListener('input', fit);
    });
});
