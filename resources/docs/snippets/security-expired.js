Nitro.hook('expired', (expired) => {
    expired.preventDefault();
    showBanner('This page was open too long. Reload to carry on.');
});
