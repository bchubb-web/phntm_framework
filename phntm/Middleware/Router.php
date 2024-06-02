<?php

namespace Bchubbweb\PhntmFramework\Middleware;

use Bchubbweb\PhntmFramework\Pages\PageInterface;
use Bchubbweb\PhntmFramework\Router as PhntmRouter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Nyholm\Psr7\Response;

class Router implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // convert PSR-7 request to Symfony request
        $httpFoundationFactory = new HttpFoundationFactory();
        $symfonyRequest = $httpFoundationFactory->createRequest($request);

        $page = (new PhntmRouter($symfonyRequest))->dispatch();

        if (!$page instanceof PageInterface) {
            return new Response($page);
        }

        // process middleware stack
        try {
            $response = $handler->handle($request);
        } catch (\RuntimeException $e) {
            $response = new Response();
        }

        $body = $page->render($symfonyRequest);

        return $response->withBody($body);
    }
}
