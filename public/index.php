<?php

define('ROOT', realpath(__DIR__ . '/../') );

require_once ROOT .'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

use Bchubbweb\PhntmFramework\Router;

$request = Request::createFromGlobals();

$router = new Router();

$context = (new RequestContext())->fromRequest($request);
$matcher = new UrlMatcher($router->routes, $context);

try {
    $attributes = $matcher->match($request->getPathInfo());

    if (!class_exists($attributes['_route'])) {
        throw new Symfony\Component\Routing\Exception\ResourceNotFoundException('Page not found');
    }

    /** @var Bchubbweb\PhntmFramework\Pages\AbstractPage $page */
    $page = new $attributes['_route']();

    $response = $page->render($request);
} catch (Symfony\Component\Routing\Exception\ResourceNotFoundException $exception) {
    $response = new Response($exception->getMessage(), 404);
} catch (Exception $exception) {
    echo $exception->getMessage() . '<br>' . $exception->getTraceAsString();
    $response = new Response('An error occurred', 500);
}

$response->send();
