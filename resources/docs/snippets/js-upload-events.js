photoInput.addEventListener('fusion-upload-progress', (event) => {
    bar.style.width = `${event.detail.progress}%`;
});
