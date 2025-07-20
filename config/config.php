<?php


return [
    
    'app' => [
        'name' => 'Manageemnt System Desing',
        'version' => '1.0.0',
        'timezone' => 'Europe/Dublin',
        'debug' => $_ENV['APP_DEBUG'] ?? false,
    ],
    'session' => [
        'name' => 'user_management_session',
        'lifetime' => 3600, 
        'path' => '/',
        'domain' => '',
        'secure' => false,
        'httponly' => true,
    ],
    'pagination' => [
        'per_page' => 10,
        'max_per_page' => 100,
    ]
];