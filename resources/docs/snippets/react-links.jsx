export default function PostNav({ postId, link, visit }) {
    return (
        <>
            <nav>
                <a {...link('/posts')}>All posts</a>
                <a {...link(`/posts/${postId}/preview`, 'prefetch.visible')}>Preview</a>
            </nav>

            <select onChange={(e) => visit(`/posts?status=${e.target.value}`)}>
                <option value="draft">Drafts</option>
                <option value="published">Published</option>
            </select>
        </>
    );
}
