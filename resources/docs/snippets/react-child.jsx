// resources/views/react/post-editor.jsx
import TagList from '../../js/components/TagList.jsx';

export default function PostEditor() {
    return <TagList />;
}

// resources/js/components/TagList.jsx: an ordinary React component, inside the view
import { useNitro } from 'nitro/react';

export default function TagList() {
    const { tags, removeTag } = useNitro();

    return (
        <ul>
            {tags.map((tag, index) => (
                <li key={tag}>{tag} <button onClick={() => removeTag(index)}>×</button></li>
            ))}
        </ul>
    );
}
