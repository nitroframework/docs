<?php

return [

    /*
    | What @nitroHead prints for a docs page: its title in this format, the description of a page
    | that does not set its own, and the image link previews show (public/social.png).
    */

    'head' => [
        'title' => '%s · Nitro',
        'description' => 'PHP components for Laravel that run in the browser. Write the logic in PHP and the view in Blade, Vue, React, Solid or Svelte; Nitro compiles the PHP to JavaScript, and calls the server only when you ask it to.',
        'image' => rtrim((string) env('APP_URL'), '/').'/social.png',
    ],

    /*
    | The Uploads page's example: images only, small, and few of them (a public site). The
    | example checks them and keeps none; Nitro removes uploads no component stored after a day.
    */

    'uploads' => [
        'directory' => storage_path('app/nitro-uploads'),
        'rules' => ['image', 'max:2048'],
        'max_files' => 1,
        'throttle' => '20,1',
    ],

    /** The site's own nitro: attributes, each run by a Nitro.directive() in resources/js. */
    'attributes' => ['autosize'],

];
