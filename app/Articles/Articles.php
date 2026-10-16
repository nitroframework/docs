<?php

namespace App\Articles;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\FrontMatter\Data\SymfonyYamlFrontMatterParser;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

/**
 * The blog's posts: one Markdown file each in resources/articles, named by its slug, with its
 * front matter on top (title, date, description; optionally updated, author, image). A post is
 * rendered once per change of its file.
 */
final class Articles
{
    /** Who wrote a post that names no author. */
    public const AUTHOR = 'Zeeshan Ali';

    /** Words read a minute, for a post's reading time. */
    private const WORDS_A_MINUTE = 200;

    /**
     * Every post, newest first, without its HTML.
     *
     * @return list<array{slug: string, title: string, description: string, date: string, published: string, updated: ?string, author: string, image: ?string, minutes: int}>
     */
    public static function all(): array
    {
        $articles = array_map(
            fn (string $file) => self::find(basename($file, '.md'))['meta'],
            glob(resource_path('articles/*.md')) ?: [],
        );

        usort($articles, fn (array $a, array $b) => [$b['date'], $b['slug']] <=> [$a['date'], $a['slug']]);

        return $articles;
    }

    /**
     * A post: what its front matter says, and its HTML. Null for a slug with no file.
     *
     * @return array{meta: array{slug: string, title: string, description: string, date: string, published: string, updated: ?string, author: string, image: ?string, minutes: int}, html: string}|null
     */
    public static function find(string $slug): ?array
    {
        $file = resource_path("articles/{$slug}.md");

        if (preg_match('/^[a-z0-9-]+$/', $slug) !== 1 || ! is_file($file)) {
            return null;
        }

        return Cache::store('file')->rememberForever('articles:'.$slug.':'.filemtime($file), fn () => self::read($slug, $file));
    }

    /**
     * The posts either side of one: the newer and the older.
     *
     * @return array{newer: ?array{slug: string, title: string}, older: ?array{slug: string, title: string}}
     */
    public static function neighbours(string $slug): array
    {
        $articles = self::all();
        $at = array_search($slug, array_column($articles, 'slug'), true);
        $link = fn (int $i) => isset($articles[$i]) ? ['slug' => $articles[$i]['slug'], 'title' => $articles[$i]['title']] : null;

        return $at === false ? ['newer' => null, 'older' => null] : ['newer' => $link($at - 1), 'older' => $link($at + 1)];
    }

    public static function url(string $slug): string
    {
        return '/blog/'.$slug;
    }

    /** @return array{meta: array<string, mixed>, html: string} */
    private static function read(string $slug, string $file): array
    {
        $document = (new FrontMatterParser(new SymfonyYamlFrontMatterParser))->parse((string) file_get_contents($file));
        $front = (array) $document->getFrontMatter();
        $html = self::headingIds((string) self::converter()->convert($document->getContent()));
        $date = self::date($front['date'] ?? null) ?? CarbonImmutable::createFromTimestamp(filemtime($file));
        $updated = self::date($front['updated'] ?? null);

        return [
            'meta' => [
                'slug' => $slug,
                'title' => (string) ($front['title'] ?? Str::headline($slug)),
                'description' => (string) ($front['description'] ?? ''),
                'date' => $date->toDateString(),
                'published' => $date->format('F j, Y'),
                'updated' => $updated?->toDateString(),
                'author' => (string) ($front['author'] ?? self::AUTHOR),
                'image' => isset($front['image']) ? (string) $front['image'] : null,
                'minutes' => max(1, (int) round(str_word_count(strip_tags($html)) / self::WORDS_A_MINUTE)),
            ],
            'html' => $html,
        ];
    }

    /** CommonMark with GitHub's tables and lists, and code blocks as the docs' (CodeBlock). */
    private static function converter(): MarkdownConverter
    {
        $environment = new Environment(['html_input' => 'allow', 'allow_unsafe_links' => false]);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new GithubFlavoredMarkdownExtension);
        $environment->addRenderer(FencedCode::class, new CodeBlock, 10);

        return new MarkdownConverter($environment);
    }

    /** Each section heading gets an id from its text: a link can point at it, and the docs' script adds its # anchor. */
    private static function headingIds(string $html): string
    {
        return (string) preg_replace_callback(
            '#<h([23])>(.*?)</h\1>#s',
            fn (array $heading) => '<h'.$heading[1].' id="'.Str::slug(html_entity_decode(strip_tags($heading[2]))).'">'.$heading[2].'</h'.$heading[1].'>',
            $html,
        );
    }

    /** A front matter date: YAML reads 2026-10-16 as a timestamp, a quoted one as text. */
    private static function date(mixed $value): ?CarbonImmutable
    {
        return match (true) {
            is_int($value) => CarbonImmutable::createFromTimestampUTC($value),
            is_string($value) && $value !== '' => CarbonImmutable::parse($value),
            default => null,
        };
    }
}
