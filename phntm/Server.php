<?php

namespace Bchubbweb\PhntmFramework;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Bchubbweb\PhntmFramework\Middleware\Auth;
use Bchubbweb\PhntmFramework\Middleware\Router;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Middlewares\Whoops;
use Relay\Relay;

class Server
{
    private RequestHandlerInterface $requestHandler;

    private ServerRequestInterface $request;

    public function __construct()
    {
        // request with all relevant data
        $symfonyRequest = Request::createFromGlobals();

        // convert to PSR-7 request
        $psrHttpFactory = new PsrHttpFactory();
        $this->request = $psrHttpFactory->createRequest($symfonyRequest);

        // free up 
        $psrHttpFactory = null;

        $this->requestHandler = new Relay([
            new Auth(),
            new Whoops(),
            new Router(),
        ]);
    }
    public function run(): void
    {
        $response = $this->requestHandler->handle($this->request);

        // send response
        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }
}
