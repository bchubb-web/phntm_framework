<?php

namespace Bchubbweb\PhntmFramework\Pages;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Bchubbweb\PhntmFramework\Pages\PageInterface;
use Bchubbweb\PhntmFramework\Pages\View;
use Bchubbweb\PhntmFramework\Router;

abstract class AbstractPage implements PageInterface
{
    protected View $view;

    abstract protected function preRender(Request $request): ?Response;

    public function render($request): Response
    {

        $relative_template_location = Router::n2r($this::class);

        if (!file_exists(ROOT . '/pages' . $relative_template_location . '/view.twig')) {
            throw new \Exception('Template not found');
        }

        $this->view = new View($relative_template_location);

        $response = static::preRender($request);

        if (is_null($response)) {
            $response = new Response();
        }

        return new Response($this->view->render());
    }
}
