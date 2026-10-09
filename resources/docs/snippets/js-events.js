// A component's $this->dispatch('cart-updated', count: 3) reaches the window too.
window.addEventListener('cart-updated', (event) => {
    badge.textContent = event.detail.params[0];
});

// Report failed server calls to your error tracker.
window.addEventListener('nitro:error', ({ detail }) => {
    Sentry.captureMessage(`${detail.component}: ${detail.message}`);
});

// Count page views after each visit.
window.addEventListener('nitro:navigated', ({ detail }) => {
    plausible('pageview', { u: detail.url });
});

// Ask before reloading when the session has expired.
window.addEventListener('nitro:expired', (event) => {
    event.preventDefault();
    showSessionExpiredDialog();
});
