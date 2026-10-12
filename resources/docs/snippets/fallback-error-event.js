Nitro.hook('error', ({ component, message, status }) => {
    Sentry.captureMessage(message, { extra: { component: component?.name, status } });
});
