Fusion.use(({ on }) => {
    on('request', ({ headers }) => {
        headers['X-Tenant'] = document.body.dataset.tenant;
    });

    on('response', ({ method, status }) => {
        if (status >= 500) reportToMonitoring(method, status);
    });
});
