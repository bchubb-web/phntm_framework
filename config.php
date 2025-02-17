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
        'url' => 'https://phntm.phntm-framework.orb.local',
        'host' => 'phntm.phntm-framework.orb.local',
    ],
    'view' => [
        'load_from' => [
            ROOT . '/layouts',
        ]
    ]
];
