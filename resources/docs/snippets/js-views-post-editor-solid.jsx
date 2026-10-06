import { createSignal, For, Show } from 'solid-js';

export default function PostEditor(props) {
    const [tag, setTag] = createSignal('');
    const [said, setSaid] = createSignal('');

    async function submit(event) {
        event.preventDefault();
        setSaid(await props.save());
    }

    return (
        <form class="post-editor" onSubmit={submit}>
            <input value={props.title} onInput={(e) => props.set('title', e.currentTarget.value)} placeholder="Title" />
            <Show when={props.errors.title}><p class="error">{props.errors.title[0]}</p></Show>

            <textarea value={props.body} onInput={(e) => props.set('body', e.currentTarget.value)} />
            <p>{props.words} words</p>

            <For each={props.tags}>{(name) => <span class="tag">{name}</span>}</For>
            <input value={tag()} onInput={(e) => setTag(e.currentTarget.value)}
                onKeyDown={(e) => e.key === 'Enter' && (e.preventDefault(), props.addTag(tag()), setTag(''))} />

            <button disabled={props.save.processing}>Save</button>
            <Show when={props.save.slow}><span>Saving…</span></Show>
            <Show when={props.unsaved.length}><span>Unsaved changes</span></Show>
            <p>{said()}</p>
        </form>
    );
}
