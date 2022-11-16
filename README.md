# Laravel Caller

> Create HTTP Clients for external services easily

## Installation

```
composer require wendelladriel/laravel-caller
```

Publish the config file with:

```
php artisan vendor:publish --provider="WendellAdriel\LaravelCaller\LaravelCallerServiceProvider" --tag=config
```

## Usage

This package provides a wrapper to the HTTP Client from Laravel to create clients for external services in an easy way.

First you need to configure one or more services in the `config/caller.php` file, the default file has an example
of a `default` service that you configure to use or create new ones based on that:

```php
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
```

After you configure your service(s) you just need to create a `Caller` class with the service `name/key` in the `config` file.
For example to create a client to a **Twitter** service you can use:

```php
<?php

namespace App;

use WendellAdriel\LaravelCaller\Caller;

// YOUR CODE HERE

$twitterClient = new Caller('twitter');
// OR YOU CAN USE THE STATIC METHOD
$twitterClient = Caller::make('twitter');
```

If you want to create a `Caller` class for the `default` service you don't need to pass any params:

```php
<?php

namespace App;

use WendellAdriel\LaravelCaller\Caller;

// YOUR CODE HERE

$twitterClient = new Caller();
// OR YOU CAN USE THE STATIC METHOD
$twitterClient = Caller::make();
```

## Making Requests

With the Caller class you have access to the same methods of the HTTP client from Laravel:
`head`, `get`, `post`, `put`, `patch` and `delete`. All of them have the same signature. Check the
get method signature below as an example:

```php
<?php

/**
 * @param string $url      - The URL for the request that will be joined with the base URL configured in the service
 * @param array  $params   - The params to be sent to the request
 * @param bool   $asForm   - If the request should be sent as "application/x-www-form-urlencoded"
 * @param bool   $isPublic - If is set to true the auth won't be configured for the request
 * @param array  $headers  - Specific headers for the request that will be merged with the headers configured in the service
 * @param array  $cookies  - Specific cookies for the request that will be merged with the cookies configured in the service
 * @param bool   $debug    - Dumps the outgoing request before it is sent and terminate the script's execution
 * @return Response
 */
public function get(
    string $url,
    array $params,
    bool $asForm = false,
    bool $isPublic = false,
    array $headers = [],
    array $cookies = [],
    bool $debug = false
): Response
```

## Updating the service

If you want to use the same `Caller` object with different services before doing a new request you can call
the `setService` method with the `name/key` of the service you want:

```php
<?php

namespace App;

use WendellAdriel\LaravelCaller\Caller;

// YOUR CODE HERE

$client = new Caller(); // USES THE DEFAULT SERVICE
$client->setService('twitter'); // CHANGES TO THE TWITTER SERVICE
```

## Using different Auth credentials

By default, the `Caller` object will use the `auth type` and `credentials` set in the `config` file. If you need to use
different auth credentials per example based on the logged user, you can overwrite those with the methods:
`setAuthUser`, `setAuthPassword`, `setAuthToken`

## Sending Attachments

If you need to send an `attachment` on your request, before calling the request use the `setAttachment` method. This will add
the attachment to your next request only. The `setAttachment` method receives a `CallerAttachment` object:

```php
<?php

namespace App;

use WendellAdriel\LaravelCaller\Caller;
use WendellAdriel\LaravelCaller\CallerAttachment;

// YOUR CODE HERE

$client = new Caller();
$client->setAttachment(new CallerAttachment('file', file_get_contents('photo.jpg'), 'photo.jpg'));

// THE ATTACHMENT CAN ALSO USE A STREAM RESOURCE AND CAN BE CREATED IN A STATIC WAY
$file = fopen('photo.jpg', 'r');
$client->setAttachment(CallerAttachment::make('file', $file, 'photo.jpg'));
```

## TO DO

- Create tests

## Credits

- [Wendell Adriel](https://github.com/WendellAdriel)
- [All Contributors](../../contributors)

## Contributing

All PRs are welcome.

For major changes, please open an issue first describing what you want to add/change.
