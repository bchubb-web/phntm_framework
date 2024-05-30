<?php

use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Bchubbweb\PhntmFramework\Middleware\Router;
use Bchubbweb\PhntmFramework\Debug;
use Middlewares\Debugbar;
use Relay\Relay;

require_once __DIR__ . '/../setup.php';

$psr17Factory = new Psr17Factory();
$psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
$request = $psrHttpFactory->createRequest(Request::createFromGlobals());

$relay = new Relay([
    (new Debugbar(Debug::getDebugBar()))->inline(),
    new Router(),
]);

$response = $relay->handle($request);
