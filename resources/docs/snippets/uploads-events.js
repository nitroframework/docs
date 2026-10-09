const input = document.querySelector('#photo');

input.addEventListener('nitro-upload-start', () => bar.hidden = false);
input.addEventListener('nitro-upload-progress', (e) => bar.value = e.detail.progress);
input.addEventListener('nitro-upload-finish', () => bar.hidden = true);
input.addEventListener('nitro-upload-error', () => bar.hidden = true);
