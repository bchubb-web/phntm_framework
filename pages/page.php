<?php

namespace Pages;

use Bchubbweb\PhntmFramework\Pages\AbstractPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Page extends AbstractPage
{
    public function preRender(Request $request): ?Response
    {
        $this->view_variables->title = 'Home';
        $this->view_variables->content = 'Welcome to the home page';
        return null;
    }
}
