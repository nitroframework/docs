public function mount(Post $post): void
{
    $this->head()
        ->title($post->title)
        ->description($post->excerpt)
        ->image($post->cover_url)
        ->canonical(route('posts.show', $post))
        ->noindex();   // A draft: kept out of search results.
}
