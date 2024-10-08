<?php
use Dotenv\Dotenv;

ob_start();

define('ROOT', realpath(__DIR__) );
define('PAGES', ROOT . '/pages');

require_once ROOT .'/vendor/autoload.php';


if (file_exists(ROOT . '/.env')) {
    $dotenv = Dotenv::createImmutable(ROOT);
    $dotenv->load();
}

require_once ROOT . '/functions.php';

if (isLocal()) {
    exec('cd ..; composer dump-autoload --optimize');
}
