<script>
    let { save } = $props();
    let notice = $state('');

    async function submit() {
        try {
            /** The method's return value; null when a rule failed (errors has the messages). */
            const said = await save();
            notice = said ?? 'Please fix the highlighted fields.';
        } catch {
            /** The request itself failed: the server's error, or no connection. save.error says why. */
            notice = `Not saved: ${save.error}`;
        }
    }
</script>

<button disabled={save.processing} onclick={submit}>
    {#if save.slow}Still saving…{:else if save.processing}Saving{:else}Save{/if}
</button>
{#if save.failed}<p class="error">{save.error}</p>{/if}
<p>{notice}</p>
