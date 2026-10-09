// config/nitro.php
'fallbacks' => [
    'enabled' => env('NITRO_FALLBACKS'),   // null: on when APP_DEBUG is off.
    'view' => 'partials.unavailable',      // For components without fallback().
],
