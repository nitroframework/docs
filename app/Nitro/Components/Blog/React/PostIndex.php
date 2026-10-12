<?php

namespace App\Nitro\Components\Blog\React;

use App\Blog\Posts;
use Nitro\Attributes\Computed;
use Nitro\Attributes\On;
use Nitro\Attributes\Server;
use Nitro\Attributes\View;
use Nitro\Component;

#[View(react: 'blog/post-index')]
class PostIndex extends Component
{
    /** @var list<array{id: string, title: string, body: string, date: string}> */
    public array $posts = [];

    public string $search = '';

    /** The post being read, and the one whose delete waits for a second click. */
    public ?string $open = null;

    public ?string $confirming = null;

    public function mount(): void
    {
        $this->posts = Posts::all();
    }

    #[Computed]
    public function results(): array
    {
        $search = mb_strtolower(trim($this->search));

        if ($search === '') {
            return $this->posts;
        }

        return array_values(array_filter(
            $this->posts,
            fn (array $post) => str_contains(mb_strtolower($post['title'].' '.$post['body']), $search),
        ));
    }

    public function read(string $id): void
    {
        $this->open = $this->open === $id ? null : $id;
    }

    public function edit(array $post): void
    {
        $this->confirming = null;
        $this->dispatch('edit-post', $post);
    }

    public function confirmDelete(?string $id): void
    {
        $this->confirming = $id;
    }

    #[Server]
    public function remove(string $id): void
    {
        Posts::delete($id);

        $this->posts = Posts::all();
        $this->confirming = null;
        $this->dispatch('post-deleted', $id);
    }

    /** The form saved a post: shown at once, no request. */
    #[On('post-saved')]
    public function saved(array $post, bool $created): void
    {
        if ($created) {
            array_unshift($this->posts, $post);

            return;
        }

        foreach ($this->posts as $i => $existing) {
            if ($existing['id'] === $post['id']) {
                $this->posts[$i] = $post;
            }
        }
    }
}
