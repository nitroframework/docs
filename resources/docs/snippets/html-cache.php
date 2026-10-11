#[Html]
public function code(): string
{
    /** One file's highlighting, made once: its hash is its content, so the key never goes stale. */
    return Cache::rememberForever("highlighted:{$this->blobSha}", fn () => $this->highlighter->html($this->blobSha));
}
