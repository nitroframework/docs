<?php

return [

    'version' => '0.x',

    'github' => 'https://github.com/ZeeshanX4/nitro-fusion',

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
            'how-it-works' => 'How Fusion works',
        ],
        'Essentials' => [
            'components' => 'Components',
            'properties' => 'Properties',
            'arrays-and-models' => 'Arrays and models',
            'methods' => 'Methods',
            'server-methods' => 'Server methods',
            'lifecycle' => 'Lifecycle',
            'views' => 'Views',
            'directives' => 'Directives',
            'sharing-state' => 'Sharing state',
            'browser-classes' => 'Browser classes and enums',
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
        ],
        'Going further' => [
            'rendering' => 'Rendering',
            'server-rendering' => 'Server rendering',
            'production' => 'Building for production',
            'configuration' => 'Configuration',
            'extending' => 'Extending Fusion',
            'javascript' => 'JavaScript API',
            'testing' => 'Testing',
            'security' => 'Security',
            'limitations' => 'Limitations',
        ],
    ],

];
