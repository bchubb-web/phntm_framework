<?php

namespace Bchubbweb\PhntmFramework;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;


/**
 * Handles routing and pages
 *
 * gathers autoloaded classes from composer and checks route matches against 
 * existing namespaces
 */
class Router
{
    public RouteCollection $routes;

    public function __construct()
    {
        $this->routes = new RouteCollection();

        $classes = $this->autoload();

        /*if (empty($classes)) {
            exec('composer dumpautoload --optimize');
            $classes = $this->autoload();
        }*/

        foreach ($classes as $pageClass => $path) {
            $this->routes->add($pageClass, new Route(self::n2r($pageClass)));
        }
    }

    /**
     * Autoloads the classes from composer or cache
     *
     * @returns array<string>
     */
    protected function autoload(): array
    {
        $res = get_declared_classes();
        $autoloaderClassName = '';
        foreach ( $res as $className) {
            if (strpos($className, 'ComposerAutoloaderInit') === 0) {
                $autoloaderClassName = $className;
                break;
            }
        }
        $classLoader = $autoloaderClassName::getLoader();
        $classes = $classLoader->getClassMap();

        $classes = array_filter($classes, function($key) {
            return (strpos($key, "Pages\\") === 0);
        }, ARRAY_FILTER_USE_KEY);

        return $classes;
    }

    /**
     * Converts a namespace to a route
     *
     * @returns string
     */
    public static function n2r(string $namespace): string
    {
        // remove the namespace and the class name suffix
        $namespace = rtrim($namespace, '\\Page');
        $namespace = ltrim($namespace, 'Pages');

        $namespace = explode('\\', $namespace);
        $namespace = implode('/', array_map('lcfirst', $namespace));
        return $namespace;
    }

    /**
     * Converts a route to a namespace
     *
     * @returns string
     */
    public static function r2n(string $route): string
    {
        $route = explode('/', $route);
        $route = implode('\\', array_map('ucfirst', $route));
        return 'Pages' . $route . '\\Page';
    }

    /**
     * Converts a route to a path path in the pages folder
     *
     * @returns string
     */
    public static function r2p(string $route): string
    {
        $route = explode('/', $route);
        $route = implode('/', array_map('ucfirst', $route));
        return $route;
    }
}
