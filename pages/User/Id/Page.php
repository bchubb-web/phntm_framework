<?php

namespace Pages\User\Id;

use Bchubbweb\PhntmFramework\Router\Dynamic;
use Bchubbweb\PhntmFramework\Pages\AbstractPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Dynamic('Pages\User\{int:id}')]
class Page extends AbstractPage
{
    public function preRender(Request $request): ?Response
    {
        $this->view_variables->title = $this->id;
        $this->view_variables->id = $this->id;
        $this->setView('./view.twig');
        return null;
    }
}
