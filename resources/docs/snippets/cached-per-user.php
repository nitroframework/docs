#[Cached(600, tags: ['drafts'], perUser: true)]
public function mount(): void
{
    $this->drafts = auth()->user()->posts()->where('status', 'draft')->count();
}
