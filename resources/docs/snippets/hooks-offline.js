// Offline: hold #[Server] calls back and say so. What changed stays, and goes with the next call.
Nitro.hook('beforeRequest', (request) => {
    if (request.kind === 'call' && !navigator.onLine) {
        request.preventDefault();
        showToast('You are offline. Your changes are kept and will be saved when you are back.');
    }
});
