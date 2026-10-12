<?php

namespace App\Nitro\Components\Blog\Blade;

use App\Blog\Posts;
use Nitro\Attributes\On;
use Nitro\Component;

/** The newest post, kept up to date by the others' events. */
class Latest extends Component
{
    /** @var array{id: string, title: string, body: string, date: string}|null */
    public ?array $post = null;

    public function mount(): void
    {
        $this->post = Posts::all()[0] ?? null;
    }

    #[On('post-saved')]
    public function saved(array $post, bool $created): void
    {
        if ($created || ($this->post !== null && $this->post['id'] === $post['id'])) {
            $this->post = $post;
        }
    }

    #[On('post-deleted')]
    public function deleted(string $id): void
    {
        if ($this->post !== null && $this->post['id'] === $id) {
            $this->post = null;
        }
    }
}
