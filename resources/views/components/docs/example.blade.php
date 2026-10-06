@props(['component', 'title' => 'Try it', 'source' => null])

{{-- A live example: a marker the docs page puts a real Fusion component in place of (App\Docs\Content). --}}
{!! '<!--fusion-example '.json_encode(['component' => $component, 'title' => $title, 'source' => $source], JSON_HEX_TAG | JSON_UNESCAPED_SLASHES).'-->' !!}
