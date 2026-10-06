public array $posts = [];
public array $tags = [];
public array $filters = [];

public function mount(): void
{
    $this->scroll('posts', fn () => Post::latest()->paginate(20))->matchOn('id');
    $this->merge('tags', fn () => Tag::popular()->get()->toArray())->matchOn('id');
    $this->deepMerge('filters', fn () => $this->defaultFilters());
}
