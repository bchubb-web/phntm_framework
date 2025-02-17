<?php

namespace Pages\User\Me;

use Phntm\Lib\Auth\Attributes\Auth;
use Phntm\Lib\Pages\AbstractPage;
use Phntm\Lib\Infra\Routing\Attributes\Dynamic;

use Symfony\Component\HttpFoundation\Request;


#[Auth('admin')]
class Page
{
    public function __invoke(Request $request): void
    {

    }
}
