<?php

namespace Pages\Sitemap;

use Phntm\Lib\Infra\Routing\Router;
use Phntm\Lib\Infra\Routing\Attributes\Alias;
use Phntm\Lib\Pages\Renderable;
use Symfony\Component\HttpFoundation\Request;

#[Alias('sitemap.xml')]
class Page extends Renderable
{
    protected bool $use_template = false;

    public function __invoke(Request $request): void
    {
        $this->withContentType('application/xml');

        $router = new Router($request);
        $routes = array_filter($router->getRoutes()->all(), function ($class) {
            return !is_a($class, \Phntm\Lib\Pages\Manageable::class, true);
        }, ARRAY_FILTER_USE_KEY);

        $this->renderWith([
            'urls' => $routes,
        ]);
    }
}
