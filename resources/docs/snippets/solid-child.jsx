// resources/views/solid/post-editor.jsx
import TagList from '../../js/solid/components/TagList.jsx';

export default function PostEditor() {
    return <TagList />;
}

// resources/js/solid/components/TagList.jsx: an ordinary Solid component, inside the view
import { For } from 'solid-js';
import { useNitro } from 'nitro/solid';

export default function TagList() {
    const nitro = useNitro();

    return (
        <ul>
            <For each={nitro.tags}>
                {(tag, index) => <li>{tag} <button onClick={() => nitro.removeTag(index())}>×</button></li>}
            </For>
        </ul>
    );
}
