<?php

namespace App\Docs;

/**
 * A docs page's content, rendered on the server (highlighting, the compiled code) and cut into
 * blocks for the page: HTML, and the live examples between it, which the page places as real
 * Fusion components so they work after a fusion:navigate visit too.
 */
final class Content
{
    /** The lead the page's content sets with <x-docs.page lead="...">. */
    public static ?string $lead = null;

    /**
     * @return array{lead: string, blocks: list<array{html?: string, component?: string, title?: string, source?: ?string}>}
     */
    public static function render(string $slug): array
    {
        self::$lead = null;
        $view = view()->exists("docs.content.{$slug}") ? "docs.content.{$slug}" : 'docs.placeholder';
        $html = view($view)->render();
        $blocks = [];

        /** A live example is a marker in the HTML (x-docs.example): the HTML around it is a block of its own. */
        foreach (preg_split('/<!--fusion-example (\{.*?\})-->/', $html, -1, PREG_SPLIT_DELIM_CAPTURE) as $i => $part) {
            if ($i % 2 === 1) {
                $blocks[] = json_decode($part, true, 4, JSON_THROW_ON_ERROR);
            } elseif (trim($part) !== '') {
                $blocks[] = ['html' => $part];
            }
        }

        return ['lead' => self::$lead ?? '', 'blocks' => $blocks];
    }
}
