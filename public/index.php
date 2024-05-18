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
$router->gatherRoutes();

var_dump($router->routes->all());

$context = (new RequestContext())->fromRequest($request);
$matcher = new UrlMatcher($router->routes, $context);
try {
    $attributes = $matcher->match($request->getPathInfo());

    if (!class_exists($attributes['_route'])) {
        throw new Symfony\Component\Routing\Exception\ResourceNotFoundException('Page not found');
    }

    // Remove the route from the attributes
    $route = $attributes['_route'];
    unset($attributes['_route']);

    /** @var Bchubbweb\PhntmFramework\Pages\AbstractPage $page */
    $page = new $route($attributes);

    $response = $page->render($request);
} catch (Symfony\Component\Routing\Exception\ResourceNotFoundException $exception) {
    $response = new Response($exception->getMessage(), 404);
} catch (Exception $exception) {
    $response = new Response($exception->getMessage(), 500);
}

$response->send();
