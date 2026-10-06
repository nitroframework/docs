const input = document.querySelector('#photo');

input.addEventListener('fusion-upload-start', () => bar.hidden = false);
input.addEventListener('fusion-upload-progress', (e) => bar.value = e.detail.progress);
input.addEventListener('fusion-upload-finish', () => bar.hidden = true);
input.addEventListener('fusion-upload-error', () => bar.hidden = true);
