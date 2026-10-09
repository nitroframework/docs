<?php

return [

    /*
    | What @nitroHead prints for a docs page: its title in this format, and the description of a
    | page that does not set its own.
    */

    'head' => [
        'title' => '%s · Nitro',
        'description' => 'Nitro compiles Laravel components, PHP classes and Blade views, to JavaScript: methods run in the browser, #[Server] methods on the server.',
        'image' => null,
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
