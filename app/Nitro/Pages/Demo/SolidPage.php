<?php

namespace App\Nitro\Pages\Demo;

use App\Blog\Posts;
use Nitro\Attributes\Computed;
use Nitro\Attributes\Layout;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Attributes\Title;
use Nitro\Attributes\Validate;
use Nitro\Attributes\View;
use Nitro\Component;

/** A page whose whole view is Solid: the blog's posts, searched in the browser, written on the server. */
#[Title('A Solid page')]
#[Layout('layouts.demo')]
#[View(solid: 'demo/page')]
class SolidPage extends Component
{
    /** @var list<array{id: string, title: string, body: string, date: string}> */
    #[Locked]
    public array $posts = [];

    public string $search = '';

    #[Validate('required|min:3|max:120')]
    public string $title = '';

    #[Validate('required|max:2000')]
    public string $body = '';

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

    #[Server]
    public function publish(): void
    {
        $this->validate();
        Posts::save(null, $this->title, $this->body);
        $this->posts = Posts::all();
        $this->reset('title', 'body');
    }
}
