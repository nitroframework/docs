addEventListener('nitro:expired', (event) => {
    event.preventDefault();
    showBanner('This page was open too long. Reload to carry on.');
});
