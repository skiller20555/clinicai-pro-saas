<?php

return [
    'driver' => 'file',
    'path' => storage_path('logs'),
    'level' => env('LOG_LEVEL', 'debug'),
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'debug',
        'days' => 14,
    ],
];
