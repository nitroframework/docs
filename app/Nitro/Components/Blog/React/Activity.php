<?php

namespace App\Nitro\Components\Blog\React;

use Nitro\Attributes\On;
use Nitro\Attributes\View;
use Nitro\Component;

/** What the other components on the page say, as they say it: it listens, and sends nothing. */
#[View(react: 'blog/activity')]
class Activity extends Component
{
    /** @var list<array{kind: string, text: string}> newest first */
    public array $events = [];

    #[On('edit-post')]
    public function editing(array $post): void
    {
        $this->add('edit-post', "Editing “{$post['title']}”");
    }

    #[On('post-saved')]
    public function saved(array $post, bool $created): void
    {
        $this->add('post-saved', ($created ? 'Published' : 'Updated')." “{$post['title']}”");
    }

    #[On('post-deleted')]
    public function deleted(string $id): void
    {
        $this->add('post-deleted', 'Deleted a post');
    }

    public function clear(): void
    {
        $this->events = [];
    }

    private function add(string $kind, string $text): void
    {
        array_unshift($this->events, ['kind' => $kind, 'text' => $text]);
        $this->events = array_slice($this->events, 0, 6);
    }
}
