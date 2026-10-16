<?php

namespace App\Nitro\Pages\Articles;

use App\Articles\Articles;
use Nitro\Attributes\Computed;
use Nitro\Attributes\Layout;
use Nitro\Attributes\Locked;
use Nitro\Component;

/** The blog: every post, newest first, searched in the browser. */
#[Layout('layouts.blog')]
class Index extends Component
{
    /** @var list<array{slug: string, title: string, description: string, date: string, published: string, updated: ?string, author: string, image: ?string, minutes: int}> */
    #[Locked]
    public array $articles = [];

    public string $search = '';

    public function mount(): void
    {
        $this->articles = Articles::all();

        $this->head()
            ->title('Blog')
            ->description('Releases, guides and how Nitro works inside, from the people who build it.')
            ->canonical(url('/blog'));
    }

    #[Computed]
    public function results(): array
    {
        $search = mb_strtolower(trim($this->search));

        if ($search === '') {
            return $this->articles;
        }

        return array_values(array_filter(
            $this->articles,
            fn (array $article) => str_contains(mb_strtolower($article['title'].' '.$article['description']), $search),
        ));
    }
}
