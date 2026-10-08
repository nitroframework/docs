<script>
    let { dispatch } = $props();
    let lastSaved = $state(null);
</script>

<!-- An event another component dispatched (without ->to()), heard in the view's own code: its values in order. -->
<svelte:window onpost-saved={(event) => (lastSaved = event.detail.params[0])} />

<button onclick={() => dispatch('preview-requested', 42)}>Preview</button>
{#if lastSaved}<p>Post {lastSaved} was just saved.</p>{/if}
