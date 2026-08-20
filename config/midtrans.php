<?php
 
return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'ip_whitelist' => [
        '103.208.23.0/24',
        '103.127.16.0/24',
        '103.127.17.0/24',
        '127.0.0.1/32',
    ],
];
