<?php

return [
    /*
    |--------------------------------------------------------------------------
    | High Traffic Optimization Settings
    |--------------------------------------------------------------------------
    */
    
    'cache' => [
        'enabled' => env('OPTIMIZATION_CACHE_ENABLED', true),
        'ttl' => env('OPTIMIZATION_CACHE_TTL', 300), // 5 minutes
        'prefix' => 'voting_',
    ],
    
    'database' => [
        'connection_pool_size' => env('DB_POOL_SIZE', 20),
        'read_replicas' => [
            'host' => env('DB_READ_HOST', '127.0.0.1'),
            'port' => env('DB_READ_PORT', '3306'),
        ],
    ],
    
    'rate_limit' => [
        'votes_per_minute' => env('RATE_LIMIT_VOTES', 10),
        'votes_per_hour' => env('RATE_LIMIT_HOURLY', 100),
    ],
    
    'cdn' => [
        'enabled' => env('CDN_ENABLED', false),
        'url' => env('CDN_URL', ''),
    ],
    
    'queue' => [
        'vote_processing' => env('QUEUE_VOTE_CONNECTION', 'redis'),
    ],
    
    'performance' => [
        'enable_lazy_loading' => true,
        'minify_assets' => env('APP_ENV') === 'production',
        'enable_http2' => true,
    ],
];
