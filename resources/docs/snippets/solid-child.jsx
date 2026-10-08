// resources/views/solid/post-editor.jsx
import TagList from '../../js/solid/components/TagList.jsx';

export default function PostEditor() {
    return <TagList />;
}

// resources/js/solid/components/TagList.jsx: an ordinary Solid component, inside the view
import { For } from 'solid-js';
import { useFusion } from 'nitro-fusion/solid';

export default function TagList() {
    const fusion = useFusion();

    return (
        <ul>
            <For each={fusion.tags}>
                {(tag, index) => <li>{tag} <button onClick={() => fusion.removeTag(index())}>×</button></li>}
            </For>
        </ul>
    );
}
