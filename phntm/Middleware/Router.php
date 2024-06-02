<?php

namespace Bchubbweb\PhntmFramework\Middleware;

use Bchubbweb\PhntmFramework\Router as PhntmRouter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

class Router implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // convert PSR-7 request to Symfony request
        $httpFoundationFactory = new HttpFoundationFactory();
        $symfonyRequest = $httpFoundationFactory->createRequest($request);

        $response = (new PhntmRouter($symfonyRequest))->dispatch();

        // convert Symfony response back to PSR-7 response
        $psrHttpFactory = new PsrHttpFactory();
        return $psrHttpFactory->createResponse($response);
    }
}
