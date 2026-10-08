export default function Cover({ cover, upload, uploads, errors }) {
    return (
        <>
            <label className="cover">
                <span>Cover image</span>
                <input type="file" accept="image/*" onChange={(e) => upload('cover', e.target.files)} />
            </label>

            {uploads.cover?.uploading && <progress max="100" value={uploads.cover.progress} />}
            {errors.cover && <p className="error">{errors.cover[0]}</p>}

            {cover && (
                <figure>
                    <img src={cover.temporaryUrl()} alt="" />
                    <figcaption>{cover.getClientOriginalName()}, {Math.round(cover.getSize() / 1024)} KB</figcaption>
                </figure>
            )}
        </>
    );
}
