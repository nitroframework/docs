<template>
    <nav>
        <a v-bind="link('/posts')">All posts</a>
        <a v-bind="link(`/posts/${postId}/preview`, 'prefetch')">Preview</a>
    </nav>

    <select @change="visit(`/posts?status=${$event.target.value}`)">
        <option value="draft">Drafts</option>
        <option value="published">Published</option>
    </select>
</template>
