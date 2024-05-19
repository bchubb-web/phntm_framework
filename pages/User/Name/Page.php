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
        $this->view_variables->title = 'User - ' . $this->name;
        $this->view_variables->content = 'Welcome to the user name page';
        $this->view_variables->name = $this->name;
        return null;
    }
}
