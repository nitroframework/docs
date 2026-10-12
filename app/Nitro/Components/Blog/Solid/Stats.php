<?php

namespace App\Nitro\Components\Blog\Solid;

use App\Blog\Posts;
use Nitro\Attributes\Computed;
use Nitro\Attributes\On;
use Nitro\Attributes\View;
use Nitro\Component;

/** The blog in numbers, kept up to date by the others' events: no request after the first. */
#[View(solid: 'blog/stats')]
class Stats extends Component
{
    /** @var array<string, int> each post's words, by its id */
    public array $words = [];

    public function mount(): void
    {
        foreach (Posts::all() as $post) {
            $this->words[$post['id']] = preg_match_all('/\S+/', $post['body']);
        }
    }

    #[Computed]
    public function posts(): int
    {
        return count($this->words);
    }

    #[Computed]
    public function total(): int
    {
        return array_sum($this->words);
    }

    #[Computed]
    public function minutes(): int
    {
        return max(1, (int) ceil($this->total() / 200));
    }

    #[On('post-saved')]
    public function saved(array $post, bool $created): void
    {
        $this->words[$post['id']] = preg_match_all('/\S+/', $post['body']);
    }

    #[On('post-deleted')]
    public function deleted(string $id): void
    {
        unset($this->words[$id]);
    }
}
