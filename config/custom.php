<?php

return [
    'theme' => env('THEME', 'light'),

    'multi_themes' => explode(',', env('MULTI_THEMES', 'light,dark')),

    'multi_langs' => explode(',', env('MULTI_LANGS', env('APP_LANG'))),

    'routes' => [
        'auth' => [
            'prefix' => env('ROUTES_AUTH_PREFIX', null),
            'enabled' => true
        ],
        'web' => [
            'prefix' => env('ROUTES_WEB_PREFIX', null),
            'enabled' => true
        ],
        'admin' => [
            'prefix' => env('ROUTES_ADMIN_PREFIX', 'admin'),
            'enabled' => true
        ],
        'api' => [
            'prefix' => env('ROUTES_API_PREFIX', 'api'),
            'enabled' => true
        ]
    ],

    'schedule' => [
        'resync' => env('SCHEDULE_RESYNC', '00')
    ],
];
