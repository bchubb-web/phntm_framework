<?php

namespace Bchubbweb\PhntmFramework\Router;

use Attribute;

#[Attribute]
class Middleware
{
    public function __construct(public array $middlewares) {}
}

