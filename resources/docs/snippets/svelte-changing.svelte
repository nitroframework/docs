<script>
    let { form = $bindable(), lines = $bindable(), set, addLine, removeLine } = $props();

    function reset() {
        /** An assignment to a $bindable prop writes the property, as bind:value does. */
        form = { email: '', gift: false };
    }
</script>

<!-- bind: on a $bindable property, or a key deep inside one. -->
<input bind:value={form.email}>
<label>
    <input type="checkbox" bind:checked={form.gift}>
    It's a gift
</label>

{#each lines as line, index (line.sku)}
    <div>
        {line.name}
        <input type="number" bind:value={line.quantity}>
        <button onclick={() => removeLine(index)}>Remove</button>
    </div>
{/each}

<!-- Or the PHP's own method, compiled to run here, or set() by path. -->
<button onclick={() => addLine('SKU-42')}>Add a line</button>
<button onclick={() => set('form.email', '')}>Clear the email</button>
<button onclick={reset}>Start again</button>
