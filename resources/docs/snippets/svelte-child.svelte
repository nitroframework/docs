<!-- resources/views/svelte/post-editor.svelte -->
<script>
    import TagList from '../../js/components/TagList.svelte';
</script>

<TagList />

<!-- resources/js/components/TagList.svelte: an ordinary Svelte component, inside the view -->
<script>
    import { useNitro } from 'nitro/svelte';

    /** Read from it in place: nitro.tags follows the component, a copy taken from it would not. */
    const nitro = useNitro();
</script>

<ul>
    {#each nitro.tags as tag, index (tag)}
        <li>{tag} <button onclick={() => nitro.removeTag(index)}>×</button></li>
    {/each}
</ul>
