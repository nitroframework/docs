$this->head()
    ->title($meta['title'])
    ->description($this->lead !== '' ? $this->lead : "{$meta['title']}: {$meta['section']} in the Fusion documentation.")
    ->canonical(url(Nav::url($page)));
