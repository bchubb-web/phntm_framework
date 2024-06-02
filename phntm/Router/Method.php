<?php

namespace Bchubbweb\PhntmFramework\Router;

use Attribute;

#[Attribute]
class Method
{
    public function __construct(public array $methods, public bool $allow = true) {
        if (empty($this->methods)) {
            throw new \Exception('Method attribute must have at least one method');
        }

        if (count(array_diff($this->methods, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) > 0){
            throw new \Exception('Method attribute must only contain GET, POST, PUT, PATCH or DELETE');
        }
    }
}
