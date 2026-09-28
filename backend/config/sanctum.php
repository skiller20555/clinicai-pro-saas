<?php

return [
    'state' => env('APP_ENV', 'production'),
    'guard' => 'web',
    'expiration' => null,
    'middleware' => ['web'],
    'edit' => [
        'models' => [
            App\Models\User::class,
        ],
    ],
];
