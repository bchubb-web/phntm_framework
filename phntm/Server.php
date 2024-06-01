<?php

namespace Bchubbweb\PhntmFramework;

use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Bchubbweb\PhntmFramework\Middleware\Router;
use Relay\Relay;

class Server
{
    public static function run(): void
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $request = $psrHttpFactory->createRequest(Request::createFromGlobals());

        $relay = new Relay([
            new Router(),
        ]);

        $response = $relay->handle($request);
    }
}
