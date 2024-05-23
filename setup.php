<?php
use Dotenv\Dotenv;

ob_start();

define('ROOT', realpath(__DIR__) );
define('PAGES', ROOT . '/pages');

require_once ROOT .'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(ROOT);
$dotenv->load();

if ($_ENV['DEP_ENV'] === 'local') {
    exec('cd ..; composer dump-autoload --optimize');
}
