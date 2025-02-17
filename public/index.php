<?php

use Phntm\Lib\Infra\Server;

require_once __DIR__ . '/../setup.php';

$server = new Server(
    services: '/services.php',
    config: '/config.php',
);
$server->run();
