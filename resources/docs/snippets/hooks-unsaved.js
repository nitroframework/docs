// Ask before leaving a page with changes the server hasn't seen yet.
Nitro.hook('beforeNavigate', (visit) => {
    const unsaved = Nitro.components().some((component) => component.unsaved().length > 0);

    if (unsaved && visit.cancelable && !confirm('You have unsaved changes. Leave this page?')) {
        visit.preventDefault();
    }
});
