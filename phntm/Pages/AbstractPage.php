<?php

namespace Bchubbweb\PhntmFramework\Pages;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Bchubbweb\PhntmFramework\Pages\PageInterface;
use Bchubbweb\PhntmFramework\Pages\View;

abstract class AbstractPage implements PageInterface
{
    protected View $view;

    abstract protected function preRender(Request $request): void;

    public function render(): Response
    {
        static::preRender();



        return new Response();
    }
}
