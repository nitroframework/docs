<?php

namespace App\Docs;

use Illuminate\Support\Facades\Cache;
use Nitro\Fusion\Build\Bundle;
use Phiki\Phiki;

/**
 * Code for the docs: highlighted with Phiki (light and dark themes in one output), with lines
 * marked: highlighted, added or removed, and the #[Server] methods.
 */
final class Code
{
    private const THEMES = ['light' => 'github-light', 'dark' => 'github-dark-default'];

    /** A file of the app (app/Fusion/..., resources/views/...), or a snippet from resources/docs/snippets. */
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
        $key = 'docs:code:'.hash('xxh128', serialize([$code, $language, $highlight, $added, $removed, self::THEMES]));

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

    /** What the browser runs for a component: its definition, from Fusion's own compiler. */
    public static function compiled(string $component): string
    {
        /** Compiling every component is slow: kept per build (the version changes with any component's files). */
        $bundle = app(Bundle::class);

        return Cache::store('file')->rememberForever('docs:compiled:'.$bundle->version().':'.$component, fn () => self::definition($bundle, $component));
    }

    private static function definition(Bundle $bundle, string $component): string
    {
        $bundle = $bundle->compileAll()[''];
        $start = strpos($bundle, 'Fusion.define('.json_encode($component));

        if ($start === false) {
            return '// '.$component.' is not compiled';
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
