<?php

/** @var array $config */
return [
    'auth' => [
        'admin' => [
            'username' => 'admin',
            'password' => 'admin',
        ],
    ],
    'db' => [
        'models' => [
            __DIR__ . '/src/Model/' => 'App\Model',
        ],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => 'db',
            'dbname' => 'app_db',
            'user' => 'app_user',
            'password' => 'app_password',
        ],
    ],
    'site' => [
        'name' => 'Acme',
        'logo' => '/images/logo.png',
    ],
    'view' => [
        'load_from' => [
            ROOT . '/view',
        ]
    ],
    'images' => [
        'load_from' => [
            ROOT . '/images',
        ],
        'public' => ROOT . '/public',
    ],
];
