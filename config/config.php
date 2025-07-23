<?php


return [
    
    'app' => [
        'name' => 'Manageemnt System Desing',
        'version' => '1.0.0',
        'timezone' => 'Europe/Kiev',
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