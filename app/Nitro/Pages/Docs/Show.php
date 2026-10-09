<?php

namespace App\Nitro\Pages\Docs;

use App\Docs\Content;
use App\Docs\Nav;
use Nitro\Attributes\Layout;
use Nitro\Attributes\Locked;
use Nitro\Component;

/**
 * A docs page. The server renders its content with App\Docs\Content. The page also knows its
 * place in the sidebar, and sets the head that search engines and link previews read.
 */
#[Layout('layouts.docs')]
class Show extends Component
{
    #[Locked]
    public string $slug = '';

    #[Locked]
    public string $title = '';

    #[Locked]
    public string $section = '';

    #[Locked]
    public string $lead = '';

    /** The page's HTML blocks and live examples, in order. */
    #[Locked]
    public array $blocks = [];

    #[Locked]
    public ?array $prev = null;

    #[Locked]
    public ?array $next = null;

    public function mount(string $page): void
    {
        $meta = Nav::page($page) ?? abort(404);
        $content = Content::render($page);

        $this->slug = $page;
        $this->title = $meta['title'];
        $this->section = $meta['section'];
        $this->lead = $content['lead'];
        $this->blocks = $content['blocks'];
        ['prev' => $this->prev, 'next' => $this->next] = Nav::neighbours($page);

        $this->head()
            ->title($meta['title'])
            ->description($this->lead !== '' ? $this->lead : "{$meta['title']}: {$meta['section']} in the Nitro documentation.")
            ->canonical(url(Nav::url($page)));
    }
}
