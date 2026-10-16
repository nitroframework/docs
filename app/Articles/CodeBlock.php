<?php

namespace App\Articles;

use Illuminate\Support\Facades\Blade;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

/**
 * A post's fenced code block, framed and highlighted as the docs' (x-docs.code). The info string
 * is the language, then optionally the file: ```php app/Nitro/Components/Todos.php
 */
final class CodeBlock implements NodeRendererInterface
{
    /** Markdown's names for a language that x-docs.code knows by another. */
    private const LANGUAGES = ['bash' => 'sh', 'shell' => 'sh', 'javascript' => 'js'];

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        FencedCode::assertInstanceOf($node);

        [$lang, $file] = array_pad(explode(' ', trim($node->getInfo() ?? ''), 2), 2, null);
        $lang = $lang === '' ? 'php' : (self::LANGUAGES[$lang] ?? $lang);

        return Blade::render('<x-docs.code :code="$code" :lang="$lang" :file="$file" />', [
            'code' => rtrim($node->getLiteral(), "\n"),
            'lang' => $lang,
            'file' => $file,
        ]);
    }
}
