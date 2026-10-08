<script>
    import { setContext } from 'svelte';
    import { createTheme } from '../../js/theme.svelte.js';
    import Toolbar from '../../js/components/Toolbar.svelte';

    let { title = $bindable() } = $props();

    /** The view is the root of its tree: what it puts in context, every component inside can get. */
    setContext('theme', createTheme());
</script>

<Toolbar />
<input bind:value={title}>
