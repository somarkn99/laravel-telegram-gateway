<?php

return [
    'api_url' => env('TELEGRAM_API_URL', 'https://gatewayapi.telegram.org/'),
    'token' => env('TELEGRAM_API_TOKEN'),
    'timeout' => 30, // Timeout for API requests
];
