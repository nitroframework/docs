use Illuminate\Support\Facades\Cache;

public function mount(): void
{
    Gate::authorize('viewStats', Post::class);   // Runs on every request.
    $this->head()->description("Posts by category, {$this->status}");

    $this->byCategory = $this->byCategory($this->status);   // Only this is kept.
}

/** The slow part, kept for five minutes per status. A private helper is never compiled for the browser. */
private function byCategory(string $status): array
{
    return Cache::remember("stats.categories.{$status}", 300, fn () => Post::where('status', $status)
        ->selectRaw('category, count(*) as posts')
        ->groupBy('category')
        ->pluck('posts', 'category')
        ->all());
}
