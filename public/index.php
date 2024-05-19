<?php

use Symfony\Component\HttpFoundation\Request;
use Bchubbweb\PhntmFramework\Router;

ob_start();

define('ROOT', realpath(__DIR__ . '/..') );
define('PAGES', ROOT . '/pages');

require_once ROOT .'/vendor/autoload.php';

$request = Request::createFromGlobals();

$router = new Router($request);

$response = $router->dispatch($request);

$response->send();
