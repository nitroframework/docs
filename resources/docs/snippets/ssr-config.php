// config/fusion.php
'ssr' => [
    'enabled' => env('FUSION_SSR', false),

    /** Where fusion:ssr listens, and where Laravel asks. */
    'url' => env('FUSION_SSR_URL', 'http://127.0.0.1:13714'),

    /** Seconds a view may take to render before the browser is left to render it. */
    'timeout' => 2,

    /** What fusion:ssr runs: the bundle `vite build --ssr` made. */
    'bundle' => base_path('bootstrap/ssr/ssr.js'),
],
