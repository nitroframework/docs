// resources/views/react/post-editor.jsx
import TagList from '../../js/components/TagList.jsx';

export default function PostEditor() {
    return <TagList />;
}

// resources/js/components/TagList.jsx: an ordinary React component, inside the view
import { useFusion } from 'nitro-fusion/react';

export default function TagList() {
    const { tags, removeTag } = useFusion();

    return (
        <ul>
            {tags.map((tag, index) => (
                <li key={tag}>{tag} <button onClick={() => removeTag(index)}>×</button></li>
            ))}
        </ul>
    );
}
