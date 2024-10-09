<?php

namespace Pages\User\Id;

use Bchubbweb\PhntmFramework\Pages\AbstractPage;
use Bchubbweb\PhntmFramework\Router\Dynamic;

use Symfony\Component\HttpFoundation\Request;


#[Dynamic('Pages\User\{int:id}')]
class Page extends AbstractPage
{
    protected function preRender(Request $request): void
    {
        $this->renderWith([
            'id' => $this->id,
        ]);
    }
}
