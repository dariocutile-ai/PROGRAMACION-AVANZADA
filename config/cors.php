<?php

return [

    'enabled' => (bool) env('CORS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Use CORS_ALLOWED_ORIGINS="http://localhost:3000,https://example.com"
    | Use "*" to allow all origins.
    |
    */
    'allowed_origins' => array_values(array_filter(
        array_map(
            static fn (string $origin): string => $origin,
            explode(',', (string) env('CORS_ALLOWED_ORIGINS', '*'))
        )
    )),

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    */
    'allowed_methods' => array_values(array_filter(
        array_map(
            static fn (string $method): string => $method,
            explode(',', (string) env('CORS_ALLOWED_METHODS', 'GET,POST,PUT,PATCH,DELETE,OPTIONS'))
        )
    )),

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    */
    'allowed_headers' => array_values(array_filter(
        array_map(
            static fn (string $header): string => $header,
            explode(',', (string) env('CORS_ALLOWED_HEADERS', 'Content-Type,Authorization,X-Requested-With,Accept,Origin'))
        )
    )),

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    */
    'exposed_headers' => array_values(array_filter(
        array_map(
            static fn (string $header): string => $header,
            explode(',', (string) env('CORS_EXPOSED_HEADERS', ''))
        )
    )),

    'supports_credentials' => (bool) env('CORS_SUPPORTS_CREDENTIALS', false),

    'max_age' => (int) env('CORS_MAX_AGE', 0),

];
