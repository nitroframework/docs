<?php

namespace App\Nitro\Components;

use Nitro\Attributes\Computed;
use Nitro\Attributes\Url;
use Nitro\Component;

class PostSearch extends Component
{
    #[Url(as: 'q')]
    public string $search = '';

    public array $posts = [
        ['title' => 'Hello, Nitro', 'author' => 'Sara', 'minutes' => 3],
        ['title' => 'Helpers every Laravel app needs', 'author' => 'Omar', 'minutes' => 6],
        ['title' => 'Writing forms that validate as you type', 'author' => 'Lena', 'minutes' => 8],
        ['title' => 'Uploads, previews and progress', 'author' => 'Omar', 'minutes' => 5],
        ['title' => 'Pages that change without a reload', 'author' => 'Sara', 'minutes' => 4],
        ['title' => 'When a method needs the server', 'author' => 'Lena', 'minutes' => 7],
    ];

    #[Computed]
    public function found(): array
    {
        return array_filter($this->posts, fn ($post) => stripos($post['title'], $this->search) !== false);
    }
}
