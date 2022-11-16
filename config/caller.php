<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SERVICES
    |--------------------------------------------------------------------------
    |
    | Here you can configure multiple services that you want to create an HTTP Client for.
    | The auth types supported are: basic, digest and token.
    | For more information on these settings check: https://laravel.com/docs/http-client
    |
    */
    'services' => [
        'default' => [
            'url'            => env('CALLER_DEFAULT_URL', 'https://example.com'),
            'timeout'        => env('CALLER_DEFAULT_TIMEOUT', 30),
            'retries'        => env('CALLER_DEFAULT_RETRIES', 0),
            'retry_after'    => env('CALLER_DEFAULT_RETRY_AFTER', 100),
            'cookies_domain' => env('CALLER_DEFAULT_COOKIES_DOMAIN', 'https://example.com'),

            'auth' => [
                'type'       => env('CALLER_DEFAULT_AUTH_TYPE', 'basic'),
                'user'       => env('CALLER_DEFAULT_AUTH_USER', 'me@example.com'),
                'password'   => env('CALLER_DEFAULT_AUTH_PASSWORD', 's3Cr3T'),
                'token'      => env('CALLER_DEFAULT_AUTH_TOKEN'),
                'token_type' => env('CALLER_DEFAULT_AUTH_TOKEN_TYPE', 'Bearer'),
            ],

            'headers' => [
                // ADD HEADERS HERE
                // 'X-First' => 'FOO',
            ],

            'cookies' => [
                // ADD COOKIES HERE
                // 'FOO' => 'BAR',
            ],
        ],
    ],
];
