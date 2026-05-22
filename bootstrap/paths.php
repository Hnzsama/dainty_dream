<?php

namespace Illuminate\Foundation;

use RuntimeException;

return [
    'paths' => [
        'app' => env('APP_PATH', 'app'),
        'base' => dirname(__DIR__),
        'bootstrap' => 'bootstrap',
        'cache' => 'bootstrap/cache',
        'database' => 'database',
        'lang' => 'resources/lang',
        'public' => 'public',
        'resources' => 'resources',
        'storage' => 'storage',
        'tests' => 'tests',
    ],
];
