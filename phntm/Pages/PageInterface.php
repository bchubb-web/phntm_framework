<?php

namespace Bchubbweb\PhntmFramework\Pages;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface PageInterface
{
    public function render(): Response;
}
