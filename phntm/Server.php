<?php

namespace Bchubbweb\PhntmFramework;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Bchubbweb\PhntmFramework\Middleware\Router;
use Bchubbweb\PhntmFramework\Middleware\Dispatcher;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Middlewares\Whoops;
use Relay\Relay;

class Server
{
    private RequestHandlerInterface $requestHandler;

    private ServerRequestInterface $request;

    public function __construct()
    {
        $responseFactory = new Psr17Factory();
        $serverRequestFactory = new ServerRequestCreator(
            $responseFactory, // ServerRequestFactory
            $responseFactory, // UriFactory
            $responseFactory, // UploadedFileFactory
            $responseFactory  // StreamFactory
        );

        $this->request = $serverRequestFactory->fromGlobals();

        // free up 
        $serverRequestFactory = null;

        $this->requestHandler = new Relay([
            new Whoops(),
            new Router($responseFactory),

            new Dispatcher($responseFactory), // must go last
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
