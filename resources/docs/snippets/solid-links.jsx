export default function PostNav(props) {
    return (
        <>
            <nav>
                <a {...props.link('/posts')}>All posts</a>
                <a {...props.link(`/posts/${props.postId}/preview`, 'prefetch.visible')}>Preview</a>
            </nav>

            <select onChange={(e) => props.visit(`/posts?status=${e.currentTarget.value}`)}>
                <option value="draft">Drafts</option>
                <option value="published">Published</option>
            </select>
        </>
    );
}
