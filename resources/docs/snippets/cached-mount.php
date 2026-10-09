<?php

namespace App\Nitro\Pages\Stats;

use App\Models\Post;
use Nitro\Attributes\Cached;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Url;
use Nitro\Component;

class Categories extends Component
{
    #[Url]
    public string $status = 'published';

    /** @var array<string, int> posts by category */
    #[Locked]
    public array $byCategory = [];

    #[Cached(300, tags: ['posts'])]
    public function mount(): void
    {
        $this->byCategory = Post::where('status', $this->status)
            ->selectRaw('category, count(*) as posts')
            ->groupBy('category')
            ->pluck('posts', 'category')
            ->all();
    }
}
