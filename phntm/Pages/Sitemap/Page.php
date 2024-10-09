<?php

namespace Bchubbweb\PhntmFramework\Pages\Sitemap;

use Bchubbweb\PhntmFramework\Pages\AbstractPage;
use Bchubbweb\PhntmFramework\Router;
use Symfony\Component\HttpFoundation\Request;

class Page extends AbstractPage
{
    protected bool $use_document = false;

    protected bool $is_framework_page = true;

    protected function preRender(Request $request): void
    {
        $this->withContentType('application/xml');

        $router = new Router($request);

        $this->renderWith([
            'urls' => $router->getRoutes()->all(),
        ]);
    }
}
