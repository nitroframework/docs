<?php

namespace App\Docs;

/** The docs' pages in the sidebar's order (config/docs.php): each one's section, and the pages before and after it. */
final class Nav
{
    /** @return array<string, array{title: string, section: string}> by slug */
    public static function pages(): array
    {
        $pages = [];

        foreach (config('docs.nav') as $section => $group) {
            foreach ($group as $slug => $title) {
                $pages[$slug] = ['title' => $title, 'section' => $section];
            }
        }

        return $pages;
    }

    /** @return array{title: string, section: string}|null */
    public static function page(string $slug): ?array
    {
        return self::pages()[$slug] ?? null;
    }

    /** @return array{prev: ?array{slug: string, title: string}, next: ?array{slug: string, title: string}} */
    public static function neighbours(string $slug): array
    {
        $slugs = array_keys(self::pages());
        $at = array_search($slug, $slugs, true);
        $at = $at === false ? null : $at;
        $link = fn (?int $i) => $i !== null && isset($slugs[$i]) ? ['slug' => $slugs[$i], 'title' => self::pages()[$slugs[$i]]['title']] : null;

        return ['prev' => $at === null ? null : $link($at - 1), 'next' => $at === null ? null : $link($at + 1)];
    }

    public static function url(string $slug): string
    {
        return '/docs/'.$slug;
    }

    /**
     * The page a mistyped or moved slug most likely meant (by its slug or title), or null when
     * none is close: what a 404 under /docs offers.
     *
     * @return array{slug: string, title: string}|null
     */
    public static function closest(string $slug): ?array
    {
        $slug = strtolower(trim($slug, '/'));
        $best = null;
        $distance = PHP_INT_MAX;

        foreach (self::pages() as $candidate => $page) {
            $title = strtolower(str_replace([' ', "'"], ['-', ''], $page['title']));
            $here = min(levenshtein($slug, $candidate), levenshtein($slug, $title));

            if ($slug !== '' && (str_contains($candidate, $slug) || str_contains($slug, $candidate))) {
                $here = min($here, 1);
            }

            if ($here < $distance) {
                [$best, $distance] = [['slug' => $candidate, 'title' => $page['title']], $here];
            }
        }

        return $best !== null && $distance <= max(2, intdiv(strlen($slug), 3)) ? $best : null;
    }
}
