<?php

namespace Bchubbweb\Phntm\Pages;

use Bchubbweb\Phntm\Pages\PageInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractPage implements PageInterface
{
    abstract public function preRender(): void;

    public function render(): Response
    {
        static::preRender();



        return new Response();
    }
}
