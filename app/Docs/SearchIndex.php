<?php

namespace App\Docs;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Illuminate\Support\Facades\File;

/**
 * What ⌘K searches: every page in the sidebar, cut at its <h2>s into sections of plain text.
 * Code blocks are left out (the prose names what they show). Built on the first request after a
 * page, snippet or config/docs.php changes, and kept in storage/framework until then.
 */
final class SearchIndex
{
    /** The longest text kept for a section. */
    private const TEXT = 1500;

    /** @return list<array{page: string, title: string, section: string, heading: ?string, anchor: ?string, text: string, code: string}> */
    public static function get(): array
    {
        $file = storage_path('framework/docs-search.json');

        if (is_file($file) && filemtime($file) >= self::changed()) {
            return json_decode(File::get($file), true, 512, JSON_THROW_ON_ERROR);
        }

        $index = self::build();
        File::put($file, json_encode($index, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));

        return $index;
    }

    /** @return list<array{page: string, title: string, section: string, heading: ?string, anchor: ?string, text: string, code: string}> */
    public static function build(): array
    {
        $entries = [];

        foreach (Nav::pages() as $slug => $meta) {
            $content = Content::render($slug);
            $html = implode('', array_column(array_filter($content['blocks'], fn ($block) => isset($block['html'])), 'html'));
            $entry = fn (?string $heading, ?string $anchor, string $text, string $code) => [
                'page' => $slug,
                'title' => $meta['title'],
                'section' => $meta['section'],
                'heading' => $heading,
                'anchor' => $anchor,
                'text' => mb_substr($text, 0, self::TEXT),
                'code' => $code,
            ];

            $sections = self::sections($html);
            $intro = array_shift($sections);
            $entries[] = $entry(null, null, trim($content['lead'].' '.$intro['text']), $intro['code']);

            foreach ($sections as $section) {
                if ($section['heading'] !== 'Next steps') {
                    $entries[] = $entry($section['heading'], $section['anchor'], $section['text'], $section['code']);
                }
            }
        }

        return $entries;
    }

    /**
     * The page's text before its first <h2>, then each <h2> with the text up to the next.
     *
     * @return list<array{heading: ?string, anchor: ?string, text: string}>
     */
    private static function sections(string $html): array
    {
        $document = new DOMDocument;
        @$document->loadHTML('<?xml encoding="utf-8"?><body>'.$html.'</body>', LIBXML_NOERROR);

        $xpath = new DOMXPath($document);
        foreach ($xpath->query('//*[@data-pair] | //*[@data-compiled] | //button | //svg | //script | //style') as $node) {
            $node->parentNode?->removeChild($node);
        }

        $sections = [['heading' => null, 'anchor' => null, 'text' => '', 'code' => '']];
        $walk = function (DOMNode $node) use (&$walk, &$sections) {
            foreach ($node->childNodes as $child) {
                $at = array_key_last($sections);
                if (! $child instanceof DOMElement) {
                    continue;
                } elseif ($child->tagName === 'h2') {
                    $sections[] = ['heading' => self::clean($child->textContent), 'anchor' => $child->getAttribute('id') ?: null, 'text' => '', 'code' => ''];
                } elseif ($child->hasAttribute('data-code')) {
                    $sections[$at]['code'] .= ' '.$child->getAttribute('data-code');
                } elseif (in_array($child->tagName, ['p', 'li', 'td', 'th', 'h3', 'h4', 'dt', 'dd'], true)) {
                    $sections[$at]['text'] .= ' '.$child->textContent;
                } else {
                    $walk($child);
                }
            }
        };
        $walk($document->getElementsByTagName('body')->item(0));

        return array_map(fn ($section) => [...$section, 'text' => self::clean($section['text']), 'code' => self::words($section['code'])], $sections);
    }

    /** The distinct names in a section's code (keys, functions, attributes, directives), for search only. */
    private static function words(string $code): string
    {
        preg_match_all('/[#@$]?\[?[A-Za-z_][\w:.\-]*\]?/', $code, $matches);
        $words = array_filter(array_unique($matches[0]), fn ($word) => strlen($word) > 2);

        return implode(' ', $words);
    }

    private static function clean(string $text): string
    {
        return trim(preg_replace('/\s+/u', ' ', $text));
    }

    /** When a page, a snippet, the sidebar or this index last changed. */
    private static function changed(): int
    {
        $times = [filemtime(config_path('docs.php')), filemtime(__FILE__)];

        foreach ([resource_path('views/docs'), resource_path('views/components/docs'), resource_path('docs/snippets')] as $directory) {
            foreach (File::allFiles($directory) as $file) {
                $times[] = $file->getMTime();
            }
        }

        return max($times);
    }
}
