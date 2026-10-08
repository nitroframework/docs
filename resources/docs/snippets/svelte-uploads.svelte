<script>
    let { cover, upload, uploads, errors } = $props();
</script>

<label class="cover">
    <span>Cover image</span>
    <input type="file" accept="image/*" onchange={(e) => upload('cover', e.currentTarget.files)}>
</label>

{#if uploads.cover?.uploading}
    <progress max="100" value={uploads.cover.progress}></progress>
{/if}
{#if errors.cover}<p class="error">{errors.cover[0]}</p>{/if}

{#if cover}
    <figure>
        <img src={cover.temporaryUrl()} alt="">
        <figcaption>{cover.getClientOriginalName()}, {Math.round(cover.getSize() / 1024)} KB</figcaption>
    </figure>
{/if}
