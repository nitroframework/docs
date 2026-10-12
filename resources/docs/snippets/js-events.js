// A component's $this->dispatch('cart-updated', count: 3) reaches the window too.
window.addEventListener('cart-updated', (event) => {
    badge.textContent = event.detail.params[0];
});

// Report what failed in the browser to your error tracker.
Nitro.hook('error', ({ component, message }) => {
    Sentry.captureMessage(`${component?.name ?? 'Nitro'}: ${message}`);
});

// Show your own dialog instead of reloading when the session has expired.
Nitro.hook('expired', (expired) => {
    expired.preventDefault();
    showSessionExpiredDialog();
});
