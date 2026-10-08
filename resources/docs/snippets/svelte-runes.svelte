<script>
    let { title = $bindable(), words, save, errors } = $props();

    /** The view's own state, as in any Svelte component. */
    let said = $state('');

    /** Props are reactive: what reads them follows the component. */
    let readingTime = $derived(Math.max(1, Math.round(words / 200)));

    $effect(() => {
        document.title = title ? `Editing: ${title}` : 'New post';
    });

    async function submit(event) {
        event.preventDefault();
        said = (await save()) ?? '';
    }
</script>

<form onsubmit={submit}>
    <input bind:value={title}>
    {#if errors.title}<p class="error">{errors.title[0]}</p>{/if}
    <p>{words} words, about {readingTime} min to read</p>

    <button disabled={save.processing}>Save</button>
    <p>{said}</p>
</form>
