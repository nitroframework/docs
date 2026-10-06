<?php

namespace App\Fusion\Components;

use App\Models\Post;
use Nitro\Fusion\Attributes\Computed;
use Nitro\Fusion\Attributes\Server;
use Nitro\Fusion\Attributes\Validate;
use Nitro\Fusion\Attributes\View;
use Nitro\Fusion\Component;

#[View(vue: 'post-editor')]
class PostEditor extends Component
{
    #[Validate('required|min:3|max:120')]
    public string $title = '';

    public string $body = '';

    public array $tags = [];

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

    #[Server]
    public function save(): string
    {
        $this->validate();

        $post = auth()->user()->posts()->create([
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags,
        ]);

        return "Saved as draft #{$post->id}";
    }
}
