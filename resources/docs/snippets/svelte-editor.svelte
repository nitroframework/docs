<script>
    let { title = $bindable(), body = $bindable(), tags, words, savedAt, addTag, removeTag, save, errors, unsaved } = $props();

    function submit(event) {
        event.preventDefault();
        save();
    }

    function addFromInput(event) {
        if (event.key !== 'Enter') return;
        event.preventDefault();
        addTag(event.currentTarget.value);
        event.currentTarget.value = '';
    }
</script>

<form class="editor" onsubmit={submit}>
    <input bind:value={title} placeholder="Title">
    {#if errors.title}<p class="error">{errors.title[0]}</p>{/if}

    <textarea bind:value={body} rows="8"></textarea>
    <p class="muted">{words} words</p>

    <ul class="tags">
        {#each tags as tag, index (tag)}
            <li>{tag} <button type="button" onclick={() => removeTag(index)}>×</button></li>
        {/each}
    </ul>
    <input placeholder="Add a tag" onkeydown={addFromInput}>

    <button disabled={save.processing}>{save.slow ? 'Saving…' : 'Save'}</button>
    {#if unsaved.length}<span class="muted">Unsaved changes</span>{/if}
    {#if savedAt}<span class="muted">Saved at {savedAt}</span>{/if}
</form>
