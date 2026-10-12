// Every request a component sends carries the current tenant.
Nitro.hook('beforeRequest', ({ headers }) => {
    headers['X-Tenant'] = document.body.dataset.tenant;
});

// A page view after each visit that went through.
Nitro.hook('afterNavigate', ({ url, cancelled }) => {
    if (!cancelled) plausible('pageview', { u: url });
});

// A hook() returns a function that removes the listener.
const stop = Nitro.hook('component.rendered', (component) => console.log(component.name, 'rendered'));
stop();
