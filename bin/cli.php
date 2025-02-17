#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use Phntm\Lib\Infra\Server;
use Phntm\Lib\Commands\Migrate;
use Phntm\Lib\Commands\Db;
use Phntm\Lib\Commands\AdminInit;

// replace with path to your own project bootstrap file
require_once __DIR__ . '/../setup.php';

new Server(
    config: '/config.php',
);

// replace with mechanism to retrieve EntityManager in your app

$commands = [
    new AdminInit('admin:init'),
    new Migrate('db:migrate'),
    new Db\Tables(),
    new Db\Schema(),
    new Db\DropAll(),
];

$application = new Application('phntm', '0.1.0');

foreach ($commands as $command) {
    $application->add($command);
}

$application->run();
