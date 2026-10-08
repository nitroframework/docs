<?php

namespace App\Fusion\Components\Svelte;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Nitro\Fusion\Attributes\Computed;
use Nitro\Fusion\Attributes\Locked;
use Nitro\Fusion\Attributes\Server;
use Nitro\Fusion\Attributes\Validate;
use Nitro\Fusion\Attributes\View;
use Nitro\Fusion\Component;
use Nitro\Fusion\Upload;

#[View(svelte: 'post-editor')]
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
