<?php

namespace Pages\User\Name;

use Bchubbweb\PhntmFramework\Pages\AbstractPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Bchubbweb\PhntmFramework\Router\Dynamic;

#[Dynamic('Pages\User\{string:name}')]
class Page extends AbstractPage
{
    public function preRender(Request $request): ?Response
    {
        $this->variables->title = 'User Name';
        $this->variables->content = 'Welcome to the user name page';
        return null;
    }
}
