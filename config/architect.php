<?php

use JPeters\Architect\Http\Middleware\Authenticate;
use JPeters\Architect\Http\Middleware\Authorise;

return [
    'name' => env('APP_NAME'),

    'route' => 'admin',

    'auth' => [
        'guard' => env('ARCHITECT_GUARD'),

        'middleware' => [
            'web',
            Authenticate::class,
            Authorise::class,
        ],

        'unauthenticated_url' => null
    ],
];
