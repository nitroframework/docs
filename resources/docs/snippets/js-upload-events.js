photoInput.addEventListener('nitro-upload-progress', (event) => {
    bar.style.width = `${event.detail.progress}%`;
});
