/**
 * fusion:autosize: a textarea that grows with its text. Its value is the most lines it grows to,
 * fusion:autosize="8"; past that, it scrolls.
 *
 * This file loads before Fusion does, so it registers the directive when Fusion is starting.
 */
document.addEventListener('fusion:starting', ({ detail: { Fusion } }) => {
    Fusion.directive('autosize', ({ el, value }) => {
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
