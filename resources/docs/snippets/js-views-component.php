<?php

namespace App\Nitro\Components;

use App\Models\Post;
use Nitro\Attributes\Computed;
use Nitro\Attributes\Server;
use Nitro\Attributes\Validate;
use Nitro\Attributes\View;
use Nitro\Component;

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
