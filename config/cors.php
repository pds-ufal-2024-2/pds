<?php

return [
    'paths' => [
        'api/*',
        'login',
        'logout',
        'sanctum/csrf-cookie',
        'user/*'
    ],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'credentials' => true,
    'supports_credentials' => true,
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
