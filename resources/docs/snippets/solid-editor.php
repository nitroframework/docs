<?php

namespace App\Nitro\Components\Solid;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Nitro\Attributes\Computed;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Attributes\Validate;
use Nitro\Attributes\View;
use Nitro\Component;
use Nitro\Upload;

#[View(solid: 'post-editor')]
class PostEditor extends Component
{
    #[Locked]
    public int $postId;

    #[Validate('required|min:3|max:120')]
    public string $title = '';

    public string $body = '';

    /** @var list<string> */
    public array $tags = [];

    #[Validate('nullable|image|max:2048')]
    public ?Upload $cover = null;

    public string $savedAt = '';

    public function mount(Post $post): void
    {
        $this->postId = $post->id;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->tags = $post->tags;
    }

    #[Computed]
    public function words(): int
    {
        return str_word_count($this->body);
    }

    public function addTag(string $tag): void
    {
        $tag = strtolower(trim($tag));

        if ($tag !== '' && ! in_array($tag, $this->tags, true)) {
            $this->tags[] = $tag;
        }
    }

    public function removeTag(int $index): void
    {
        array_splice($this->tags, $index, 1);
    }

    #[Server]
    public function save(): string
    {
        $this->validate();
        $post = Post::findOrFail($this->postId);
        Gate::authorize('update', $post);

        $post->update([
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags,
            'cover' => $this->cover?->store('covers', 'public') ?? $post->cover,
        ]);

        $this->cover = null;
        $this->savedAt = now()->format('H:i');
        $this->dispatch('post-saved', id: $post->id);

        return "Saved at {$this->savedAt}";
    }
}
