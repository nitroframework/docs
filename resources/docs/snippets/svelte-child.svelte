<!-- resources/views/svelte/post-editor.svelte -->
<script>
    import TagList from '../../js/components/TagList.svelte';
</script>

<TagList />

<!-- resources/js/components/TagList.svelte: an ordinary Svelte component, inside the view -->
<script>
    import { useFusion } from 'nitro-fusion/svelte';

    /** Read from it in place: fusion.tags follows the component, a copy taken from it would not. */
    const fusion = useFusion();
</script>

<ul>
    {#each fusion.tags as tag, index (tag)}
        <li>{tag} <button onclick={() => fusion.removeTag(index)}>×</button></li>
    {/each}
</ul>
