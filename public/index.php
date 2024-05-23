<?php

use Symfony\Component\HttpFoundation\Request;
use Bchubbweb\PhntmFramework\Router;

require_once __DIR__ . '/../setup.php';

$request = Request::createFromGlobals();

$response = (new Router($request))->dispatch($request);

$response->send();
