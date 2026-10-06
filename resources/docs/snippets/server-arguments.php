use App\Enums\Status;
use App\Models\Post;
use App\Services\Search;
use Illuminate\Support\Facades\Gate;
use Nitro\Fusion\Attributes\Server;

#[Server]
public function remove(Post $post): void              // Receives the record the key names, or answers 404.
{
    Gate::authorize('delete', $post);
    $post->delete();
}

#[Server]
public function setStatus(Post $post, Status $status): void   // Receives the case the value names.
{
    Gate::authorize('update', $post);
    $post->update(['status' => $status]);
}

#[Server]
public function search(Search $search): void          // Resolved from the container.
{
    $this->results = $search->for($this->query);
}
