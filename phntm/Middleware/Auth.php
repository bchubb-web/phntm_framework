<?php

namespace Bchubbweb\PhntmFramework\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Nyholm\Psr7\Response;

class Auth implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // allow access to all routes that do not start with /admin
        if (strpos($request->getUri()->getPath(), '/admin') !== 0) {
            return $handler->handle($request);
        }

        // return 403 response
        $response = new Response();
        return $response->withStatus(403);
    }
}
