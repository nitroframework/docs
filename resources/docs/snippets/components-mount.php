<?php

namespace App\Nitro\Components;

use App\Models\Post;
use App\Services\ReadingTime;
use Nitro\Attributes\Locked;
use Nitro\Component;

class PostSummary extends Component
{
    #[Locked]
    public int $postId;

    public string $readingTime = '';

    public array $comments = [];

    /**
     * Runs once, on the server: the tag's values by name (:post="$post"), and anything else
     * Laravel's container can give, as in a controller.
     */
    public function mount(Post $post, ReadingTime $readingTime): void
    {
        $this->postId = $post->id;
        $this->readingTime = $readingTime->of($post->body);
        $this->comments = $post->comments()->latest()->take(3)->get(['author', 'body'])->toArray();
    }
}
