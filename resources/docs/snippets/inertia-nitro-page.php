<?php

namespace App\Nitro\Pages\Posts;

use App\Models\Post;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Attributes\Title;
use Nitro\Attributes\Validate;
use Nitro\Attributes\View;
use Nitro\Component;

#[Title('Post')]
#[View(vue: 'posts/show')]
class Show extends Component
{
    #[Locked]
    public array $post = [];

    #[Validate('required|max:1000')]
    public string $comment = '';

    public function mount(Post $post): void
    {
        $this->post = $post->only('id', 'title', 'body');
    }

    #[Server]
    public function addComment(): void
    {
        $this->validate();
        Post::findOrFail($this->post['id'])->comments()->create(['body' => $this->comment, 'user_id' => auth()->id()]);
        $this->reset('comment');
    }
}
