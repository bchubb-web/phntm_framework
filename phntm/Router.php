<?php

namespace Bchubbweb\PhntmFramework;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use ReflectionClass;


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

        if (empty($this->autoload())) {
            exec('composer dumpautoload --optimize');
        }

    }

    /**
     * Gathers all Pages\\ routes from autoloaded classes
     * and adds them to the RouteCollection
     *
     * parses Dynamic attributes to gather route variables and their types
     */
    public function gatherRoutes(): void
    {
        $classes = $this->autoload();

        foreach ($classes as $pageClass => $path) {

            $reflection = new ReflectionClass($pageClass);
            if ($reflection->getAttributes('Bchubbweb\PhntmFramework\Router\Dynamic')) {
                $denoted_namespace = $reflection->getAttributes('Bchubbweb\PhntmFramework\Router\Dynamic')[0]->getArguments()[0];

                $parts = explode('\\', $denoted_namespace);

                $variables = array_filter($parts, function(string $part) {
                    return (strpos($part, '{') === 0 && strpos($part, '}') === strlen($part) - 1);
                });
                $variables = array_map(function(string $part) {
                    return substr($part, 1, strlen($part) - 2);
                }, $variables);

                $mapped_variables = [];
                $validation_regexes = [];

                foreach ($variables as $variable) {
                    $default = '';
                    if (strpos($variable, ':') !== false) {
                        [$type, $variable] = explode(':', $variable);
                        $default = match($type) {
                            'int' => -1,
                            'string' => '',
                            'float' => 0.0,
                            'bool' => false,
                            'array' => [],
                            default => '',
                        };
                    }
                    $mapped_variables[$variable] = $default;
                    $validation_regexes[$variable] = match($type) {
                        'int' => '\d+',
                        'string' => '\w+',
                        'float' => '\d+\.\d+',
                        'bool' => 'true|false|1|0|yes|no',
                        'array' => '\w+',
                        default => '\w+',
                    };
                }

                $denoted_namespace_without_types = preg_replace('/{(\w+):([^}]+)}/', '{$2}', $denoted_namespace);

                $this->routes->add($pageClass, new Route(self::n2r($denoted_namespace_without_types), $mapped_variables), 1);
                continue;
            }

            $this->routes->add($pageClass, new Route(self::n2r($pageClass)), 2);
        }
    }

    /**
     * Dispatches a route
     *
     * @returns Route
     */
    public function dispatch(string $route): Route
    {
        return $this->routes->get($route);
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
        $namespace = preg_replace('/\\\Page$/', '', $namespace);
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
