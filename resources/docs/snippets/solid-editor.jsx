import { For, Show } from 'solid-js';

export default function PostEditor(props) {
    function submit(event) {
        event.preventDefault();
        props.save();
    }

    function addFromInput(event) {
        if (event.key !== 'Enter') return;
        event.preventDefault();
        props.addTag(event.currentTarget.value);
        event.currentTarget.value = '';
    }

    return (
        <form class="editor" onSubmit={submit}>
            <input value={props.title} onInput={(e) => props.set('title', e.currentTarget.value)} placeholder="Title" />
            <Show when={props.errors.title}>{(messages) => <p class="error">{messages()[0]}</p>}</Show>

            <textarea value={props.body} onInput={(e) => props.set('body', e.currentTarget.value)} rows={8} />
            <p class="muted">{props.words} words</p>

            <ul class="tags">
                <For each={props.tags}>
                    {(tag, index) => <li>{tag} <button type="button" onClick={() => props.removeTag(index())}>×</button></li>}
                </For>
            </ul>
            <input placeholder="Add a tag" onKeyDown={addFromInput} />

            <button disabled={props.save.processing}>{props.save.slow ? 'Saving…' : 'Save'}</button>
            <Show when={props.unsaved.length}><span class="muted">Unsaved changes</span></Show>
            <Show when={props.savedAt}><span class="muted">Saved at {props.savedAt}</span></Show>
        </form>
    );
}
