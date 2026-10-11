<?php

return [

    'version' => '2.x',

    'github' => 'https://github.com/nitroframework/nitro',

    'sponsor' => 'https://github.com/sponsors/nitroframework',

    /**
     * Search (⌘K). When a result on another page is opened, the dialog closes 'before' the visit
     * starts, or 'after' the new page is shown, marking the result as loading meanwhile.
     */
    'search' => [
        'close' => 'before',
    ],

    /** The sidebar: groups of pages, by slug. */
    'nav' => [
        'Getting started' => [
            'introduction' => 'Introduction',
            'installation' => 'Installation',
            'quickstart' => 'Quickstart',
            'how-it-works' => 'How Nitro works',
        ],
        'Essentials' => [
            'components' => 'Components',
            'properties' => 'Properties',
            'arrays-and-models' => 'Arrays and models',
            'methods' => 'Methods',
            'server-methods' => 'Server methods',
            'lifecycle' => 'Lifecycle',
            'views' => 'Views',
            'html' => 'Server-made HTML',
            'directives' => 'Directives',
            'sharing-state' => 'Sharing state',
            'browser-classes' => 'Browser classes and enums',
            'attributes' => 'Attributes',
        ],
        'JavaScript views' => [
            'javascript-views' => 'Overview',
            'vue' => 'Vue',
            'react' => 'React',
            'solid' => 'Solid',
            'svelte' => 'Svelte',
        ],
        'Pages' => [
            'pages' => 'Pages',
            'navigation' => 'Navigation',
            'head' => "The page's head",
            'page-data' => 'Page data',
        ],
        'Features' => [
            'forms' => 'Forms and validation',
            'uploads' => 'Uploads',
            'events' => 'Events',
            'transitions' => 'Transitions',
            'islands' => 'Islands',
            'browser-apis' => 'Browser APIs',
            'libraries' => 'Third-party libraries',
            'caching' => 'Caching',
            'errors' => 'Handling errors',
        ],
        'Going further' => [
            'rendering' => 'Rendering',
            'server-rendering' => 'Server rendering',
            'production' => 'Building for production',
            'configuration' => 'Configuration',
            'extending' => 'Extending Nitro',
            'namespaces' => 'Modules and packages',
            'javascript' => 'JavaScript API',
            'testing' => 'Testing',
            'debugging' => 'Debugging',
            'security' => 'Security',
            'limitations' => 'Limitations',
        ],
    ],

];
