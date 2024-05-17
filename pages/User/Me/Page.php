<?php

namespace Pages\User\Me;

use Bchubbweb\PhntmFramework\Pages\AbstractPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Page extends AbstractPage
{
    public function preRender(Request $request): ?Response
    {
        $this->view_variables->title = 'MEEE';
        $this->setView('../Id/view.twig');
        return null;
    }
}
