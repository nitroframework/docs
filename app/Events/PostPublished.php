<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

/**
 * A post written or changed, broadcast through Reverb to the reader's channel: their other tabs
 * hear it (#[On('echo:blog.{channel},PostPublished')]).
 */
class PostPublished implements ShouldBroadcastNow
{
    /** @param  array{id: string, title: string, body: string, date: string}  $post */
    public function __construct(
        public string $channel,
        public array $post,
        public bool $created,
    ) {
    }

    public function broadcastOn(): Channel
    {
        return new Channel("blog.{$this->channel}");
    }

    /** @return array{id: string, title: string, created: bool, at: string} */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->post['id'],
            'title' => $this->post['title'],
            'created' => $this->created,
            'at' => now()->format('H:i:s'),
        ];
    }
}
