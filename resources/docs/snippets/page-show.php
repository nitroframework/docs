namespace App\Nitro\Pages\Posts;

use App\Models\Post;
use Nitro\Attributes\Layout;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Attributes\Title;
use Nitro\Component;

#[Title('Post')]
#[Layout('components.layouts.app')]
class Show extends Component
{
    #[Locked]
    public array $post = [];

    public string $comment = '';

    public function mount(Post $post): void
    {
        $this->post = $post->only('id', 'title', 'body');
    }

    #[Server]
    public function addComment(): void
    {
        $this->validate(['comment' => 'required|max:1000']);
        Post::findOrFail($this->post['id'])->comments()->create(['body' => $this->comment, 'user_id' => auth()->id()]);
        $this->reset('comment');
    }
}
