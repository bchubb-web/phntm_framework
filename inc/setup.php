<?php
use Dotenv\Dotenv;

ini_set('pdo_mysql.default_socket', '"/var/lib/mysql/mysqlx.sock"');
ob_start();

define('ROOT', realpath(__DIR__ . '/../') );
define('PAGES', ROOT . '/pages');
define('PHNTM', '/vendor/bchubbweb/phntm-lib/');

// fuck middlewares
error_reporting(E_ALL ^ E_DEPRECATED);

require_once ROOT .'/vendor/autoload.php';


if (file_exists(ROOT . '/.env')) {
    $dotenv = Dotenv::createImmutable(ROOT);
    $dotenv->load();
}

require_once ROOT . '/inc/functions.php';
