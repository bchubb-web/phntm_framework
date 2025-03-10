<?php

use Phntm\Lib\Infra\Server;

require_once __DIR__ . '/../inc/setup.php';

$server = new Server(
    services: '/inc/services.php',
    config: '/inc/config.php',
);
$server->run();
