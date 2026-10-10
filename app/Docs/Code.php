<?php

namespace App\Docs;

use Illuminate\Support\Facades\Cache;
use Nitro\Build\Bundle;
use Phiki\Phiki;

/**
 * Code for the docs: highlighted with Phiki (light and dark themes in one output), with lines
 * marked: highlighted, added or removed, and the #[Server] methods.
 */
final class Code
{
    private const THEMES = ['light' => 'github-light', 'dark' => 'github-dark-default'];

    /** A file of the app (app/Nitro/..., resources/views/...), or a snippet from resources/docs/snippets. */
    public static function snippet(string $path): string
    {
        $file = is_file(base_path($path)) ? base_path($path) : resource_path('docs/snippets/'.$path);

        return rtrim((string) file_get_contents($file), "\n");
    }

    /**
     * The code as highlighted HTML.
     *
     * @param  list<int>  $highlight  lines to highlight (1-based)
     * @param  list<int>  $added
     * @param  list<int>  $removed
     */
    public static function html(string $code, string $language, array $highlight = [], array $added = [], array $removed = []): string
    {
        /** Highlighting is slow (a grammar per token): kept by the code and its marks, worked out once. */
        $key = 'docs:code:'.hash('xxh128', serialize([$code, $language, $highlight, $added, $removed, self::THEMES, 'compact-2']));

        return Cache::store('file')->rememberForever($key, fn () => self::highlight($code, $language, $highlight, $added, $removed));
    }

    /**
     * @param  list<int>  $highlight
     * @param  list<int>  $added
     * @param  list<int>  $removed
     */
    private static function highlight(string $code, string $language, array $highlight, array $added, array $removed): string
    {
        $html = (new Phiki)->codeToHtml($code, self::grammar($language), self::THEMES)->toString();
        $lines = explode("\n", $code);
        $server = [];

        /** The line of each #[Server] method's signature: marked "server". */
        foreach ($lines as $i => $line) {
            if (str_contains($line, '#[Server]') && isset($lines[$i + 1])) {
                $server[] = $i + 2;
            }
        }

        $n = 0;
        $html = self::compact($html);

        return (string) preg_replace_callback('/<span class="line">/', function () use (&$n, $highlight, $added, $removed, $server) {
            $n++;
            $classes = array_filter([
                in_array($n, $highlight, true) ? 'is-highlighted' : null,
                in_array($n, $added, true) ? 'is-added' : null,
                in_array($n, $removed, true) ? 'is-removed' : null,
                in_array($n, $server, true) ? 'is-server' : null,
            ]);

            return '<span class="'.implode(' ', ['line', ...$classes]).'">';
        }, $html);
    }

    /**
     * Phiki's tokens with short classes in place of their inline styles: l-<hex> for the light
     * theme's colour, d-<hex> for the dark one's, t-b and t-i for bold and italic (css() has the
     * rules). A token in the block's own colours is plain text, and neighbours alike are one span.
     */
    private static function compact(string $html): string
    {
        preg_match('/<pre[^>]* style="[^"]*?(?:^|;|")color: #([0-9a-fA-F]+)/', $html, $lightDefault);
        preg_match('/--phiki-dark-color: #([0-9a-fA-F]+)/', $html, $darkDefault);
        $lightDefault = strtolower($lightDefault[1] ?? '');
        $darkDefault = strtolower($darkDefault[1] ?? '');

        $html = (string) preg_replace_callback('/<span class="token"(?: style="([^"]*)")?>([^<]*)<\/span>/', function (array $token) use ($lightDefault, $darkDefault) {
            $style = $token[1];
            $light = preg_match('/(?:^|;)color: #([0-9a-fA-F]+)/', $style, $l) === 1 ? strtolower($l[1]) : null;
            $dark = preg_match('/--phiki-dark-color: #([0-9a-fA-F]+)/', $style, $d) === 1 ? strtolower($d[1]) : null;

            /** The block's own colours, in both themes: nothing to say. */
            if ($light === $lightDefault && ($dark ?? $darkDefault) === $darkDefault) {
                $light = $dark = null;
            }

            $classes = array_filter([
                $light !== null ? 'l-'.$light : null,
                $light !== null || ($dark !== null && $dark !== $darkDefault) ? 'd-'.($dark ?? $darkDefault) : null,
                str_contains($style, 'font-weight: bold') ? 't-b' : null,
                str_contains($style, 'font-style: italic') ? 't-i' : null,
            ]);

            return $classes === [] || trim(html_entity_decode($token[2])) === '' ? $token[2] : '<span class="'.implode(' ', $classes).'">'.$token[2].'</span>';
        }, $html);

        do {
            $html = (string) preg_replace('/(<span class="([^"]+)">[^<]*)<\/span><span class="\2">/', '$1', $html, -1, $merged);
        } while ($merged > 0);

        return $html;
    }

    /** The rules for compact()'s classes: every colour of both themes, worked out once. */
    public static function css(): string
    {
        return Cache::store('file')->rememberForever('docs:code-css:'.implode(',', self::THEMES), function () {
            $colours = fn (string $theme) => array_unique(array_map('strtolower', preg_match_all('/#([0-9a-fA-F]{6,8})\b/', (string) file_get_contents(base_path("vendor/phiki/phiki/resources/themes/{$theme}.json")), $m) ? $m[1] : []));

            return implode('', [
                ...array_map(fn ($hex) => ".code-frame .l-{$hex}{color:#{$hex}}", $colours(self::THEMES['light'])),
                ...array_map(fn ($hex) => ".dark .code-frame .d-{$hex}{color:#{$hex}}", $colours(self::THEMES['dark'])),
                '.code-frame .t-b{font-weight:700}.code-frame .t-i{font-style:italic}',
            ]);
        });
    }

    /**
     * What the browser runs for a component: its definition, from Nitro's own compiler, or null
     * for a name the bundle doesn't have. Fetched when its "Compiled" panel first opens.
     */
    public static function compiled(string $component): ?string
    {
        /** Compiling every component takes a moment: kept per build (the version changes with any component's files). */
        $bundle = app(Bundle::class);
        $key = 'docs:compiled:'.$bundle->version().':'.$component;

        if (($definition = Cache::store('file')->get($key)) === null && ($definition = self::definition($bundle, $component)) !== null) {
            Cache::store('file')->forever($key, $definition);
        }

        return $definition;
    }

    private static function definition(Bundle $bundle, string $component): ?string
    {
        $bundle = $bundle->compileAll()[''];
        $start = strpos($bundle, 'Nitro.define('.json_encode($component));

        if ($start === false) {
            return null;
        }

        $end = strpos($bundle, "\n});", $start);

        return substr($bundle, $start, $end === false ? null : $end - $start + 4);
    }

    private static function grammar(string $language): string
    {
        return match ($language) {
            'blade' => 'blade',
            'js', 'javascript' => 'javascript',
            'vue' => 'vue',
            'svelte' => 'svelte',
            'jsx' => 'jsx',
            'sh', 'shell', 'bash' => 'shellscript',
            'json' => 'json',
            'html' => 'html',
            'css' => 'css',
            'ini' => 'ini',
            default => 'php',
        };
    }
}
