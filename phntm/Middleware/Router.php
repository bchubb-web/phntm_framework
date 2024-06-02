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
    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // convert PSR-7 request to Symfony request for use in router
        $httpFoundationFactory = new HttpFoundationFactory();
        $symfonyRequest = $httpFoundationFactory->createRequest($request);
        
        // the router will return a found page or a relevant status code
        $page = (new PhntmRouter($symfonyRequest))->dispatch();

        if (!$page instanceof PageInterface) {
            return new Response($page);
        }

        // attempt to process middleware stack
        try {
            $response = $handler->handle($request);
        } catch (\RuntimeException $e) {
            $response = new Response();
        }

        // render the page content
        $body = $page->render($symfonyRequest);

        // return response with page body
        return $response->withBody($body);
    }
}
