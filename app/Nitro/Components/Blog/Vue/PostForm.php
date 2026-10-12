<?php

namespace App\Nitro\Components\Blog\Vue;

use App\Blog\Posts;
use Nitro\Attributes\Computed;
use Nitro\Attributes\On;
use Nitro\Attributes\Server;
use Nitro\Attributes\Validate;
use Nitro\Attributes\View;
use Nitro\Component;

#[View(vue: 'blog/post-form')]
class PostForm extends Component
{
    /** The post being edited; null for a new one. Posts::save() finds it among this reader's own posts. */
    public ?string $postId = null;

    #[Validate('required|string|max:120')]
    public string $title = '';

    #[Validate('required|string|max:2000')]
    public string $body = '';

    public string $notice = '';

    #[Computed]
    public function words(): int
    {
        return preg_match_all('/\S+/', $this->body);
    }

    #[On('edit-post')]
    public function edit(array $post): void
    {
        $this->postId = $post['id'];
        $this->title = $post['title'];
        $this->body = $post['body'];
        $this->notice = '';
    }

    #[On('post-deleted')]
    public function deleted(string $id): void
    {
        if ($this->postId === $id) {
            $this->cancel();
        }
    }

    public function cancel(): void
    {
        $this->reset('postId', 'title', 'body', 'notice');
    }

    #[Server]
    public function save(): void
    {
        $this->validate();

        $created = $this->postId === null;
        $post = Posts::save($this->postId, $this->title, $this->body);

        $this->reset('postId', 'title', 'body');
        $this->notice = $created ? 'Published.' : 'Updated.';
        $this->dispatch('post-saved', $post, $created);
    }
}
