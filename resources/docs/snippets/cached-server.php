public string $status = 'published';

public string $category = '';

/** @var list<string> */
public array $titles = [];

#[Server]
#[Cached(300, tags: ['posts'], by: ['status'])]
public function inCategory(string $category): void
{
    $this->category = $category;
    $this->titles = Post::where('status', $this->status)
        ->where('category', $category)
        ->latest()
        ->pluck('title')
        ->all();
}
