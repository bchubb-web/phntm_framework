<?php

namespace Bchubbweb\Phntm\Pages;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface PageInterface
{
    protected function preRender(Request $request): Response;

    public function render(): Response;

    pro
}
