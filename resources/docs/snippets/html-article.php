<?php

namespace App\Nitro\Pages\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Nitro\Attributes\Html;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Component;

class Show extends Component
{
    #[Locked]
    public int $postId;

    public string $title = '';

    public string $markdown = '';

    public function mount(Post $post): void
    {
        $this->postId = $post->id;
        $this->title = $post->title;
        $this->markdown = $post->body;
    }

    /** The post's body as HTML: made on the server, placed by the view. */
    #[Html]
    public function body(): string
    {
        return Str::markdown($this->markdown, ['html_input' => 'escape']);
    }

    #[Server]
    public function save(): void
    {
        Gate::authorize('update', $post = Post::findOrFail($this->postId));
        $post->update(['body' => $this->markdown]);
    }
}
