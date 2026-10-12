Nitro.use(({ on }) => {
    on('beforeRequest', ({ headers }) => {
        headers['X-Tenant'] = document.body.dataset.tenant;
    });

    on('afterRequest', ({ method, status }) => {
        if (status >= 500) reportToMonitoring(method, status);
    });
});
