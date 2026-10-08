<script>
    let { postId, link, visit } = $props();
</script>

<nav>
    <a {...link('/posts')}>All posts</a>
    <a {...link(`/posts/${postId}/preview`, 'prefetch')}>Preview</a>
</nav>

<select onchange={(e) => visit(`/posts?status=${e.currentTarget.value}`)}>
    <option value="draft">Drafts</option>
    <option value="published">Published</option>
</select>
