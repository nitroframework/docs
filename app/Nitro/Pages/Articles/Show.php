<?php

namespace App\Nitro\Pages\Articles;

use App\Articles\Articles;
use Nitro\Attributes\Layout;
use Nitro\Attributes\Locked;
use Nitro\Component;

/**
 * A blog post. The server renders its Markdown (App\Articles\Articles); the page sets the head
 * link previews read, and the structured data search engines read for an article.
 */
#[Layout('layouts.blog')]
class Show extends Component
{
    /** @var array{slug: string, title: string, description: string, date: string, published: string, updated: ?string, author: string, image: ?string, minutes: int} */
    #[Locked]
    public array $article = [];

    #[Locked]
    public string $html = '';

    /** The post as JSON-LD (schema.org's BlogPosting). */
    #[Locked]
    public string $schema = '';

    #[Locked]
    public ?array $newer = null;

    #[Locked]
    public ?array $older = null;

    public function mount(string $slug): void
    {
        $found = Articles::find($slug) ?? abort(404);
        $this->article = $found['meta'];
        $this->html = $found['html'];
        ['newer' => $this->newer, 'older' => $this->older] = Articles::neighbours($slug);

        $url = url(Articles::url($slug));
        $image = $this->article['image'] !== null ? url($this->article['image']) : null;

        $this->schema = json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $this->article['title'],
            'description' => $this->article['description'],
            'datePublished' => $this->article['date'],
            'dateModified' => $this->article['updated'] ?? $this->article['date'],
            'author' => ['@type' => 'Person', 'name' => $this->article['author']],
            'publisher' => ['@type' => 'Organization', 'name' => 'Nitro', 'url' => url('/')],
            'mainEntityOfPage' => $url,
            'image' => $image ?? config('nitro.head.image'),
        ]), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_THROW_ON_ERROR);

        $head = $this->head()
            ->title($this->article['title'])
            ->description($this->article['description'])
            ->canonical($url)
            ->meta('author', $this->article['author']);

        if ($image !== null) {
            $head->image($image);
        }
    }
}
