use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

public Collection $posts;

public function mount(): void
{
    $this->posts = Post::with('author')->latest()->take(20)->get();
}

#[Server]
public function publish(Post $post): void
{
    Gate::authorize('update', $post);
    $post->update(['published_at' => now()]);
}
