<?php

namespace Pages\Blog\Page;

use Bchubbweb\PhntmFramework\Pages\AbstractPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Bchubbweb\PhntmFramework\Router\Dynamic;

#[Dynamic('Pages\Blog\{int:page}')]
class Page extends AbstractPage
{
    public function preRender(Request $request): ?Response
    {
        $this->view_variables->title = $this->page;
        $this->view_variables->id = $this->page;

        return null;
    }
}
