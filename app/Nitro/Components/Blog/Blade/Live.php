<?php

namespace App\Nitro\Components\Blog\Blade;

use App\Blog\Posts;
use Nitro\Attributes\Locked;
use Nitro\Attributes\On;
use Nitro\Component;

/**
 * Posts as Reverb delivers them: Posts::save() broadcasts PostPublished to the reader's own
 * channel, and every tab they have open on this page hears it, this one too.
 */
class Live extends Component
{
    /** The reader's channel: only their session knows its name. */
    #[Locked]
    public string $channel = '';

    /** @var list<array{id: string, title: string, created: bool, at: string}> newest first */
    public array $feed = [];

    public function mount(): void
    {
        $this->channel = Posts::channel();
    }

    /** A broadcast arrived: it runs in the browser, with the event's data. */
    #[On('echo:blog.{channel},PostPublished')]
    public function published(array $event): void
    {
        array_unshift($this->feed, $event);
        $this->feed = array_slice($this->feed, 0, 5);
    }
}
