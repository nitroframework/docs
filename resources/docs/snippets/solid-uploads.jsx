import { Show } from 'solid-js';

export default function Cover(props) {
    return (
        <>
            <label class="cover">
                <span>Cover image</span>
                <input type="file" accept="image/*" onChange={(e) => props.upload('cover', e.currentTarget.files)} />
            </label>

            <Show when={props.uploads.cover?.uploading}>
                <progress max="100" value={props.uploads.cover.progress} />
            </Show>
            <Show when={props.errors.cover}><p class="error">{props.errors.cover[0]}</p></Show>

            <Show when={props.cover}>
                {(cover) => (
                    <figure>
                        <img src={cover().temporaryUrl()} alt="" />
                        <figcaption>{cover().getClientOriginalName()}, {Math.round(cover().getSize() / 1024)} KB</figcaption>
                    </figure>
                )}
            </Show>
        </>
    );
}
