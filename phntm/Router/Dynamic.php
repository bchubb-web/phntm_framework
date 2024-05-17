<?php

namespace Bchubbweb\PhntmFramework\Router;

use Attribute;

#[Attribute]
class Dynamic
{
    public function __construct(private string $denoted_namespace)
    {
    }
}
