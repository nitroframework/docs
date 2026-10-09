window.addEventListener('nitro:error', (event) => {
    const { component, message, status } = event.detail;
    Sentry.captureMessage(message, { extra: { component: component?.name, status } });
});
