<?php

namespace Pages;

use Bchubbweb\PhntmFramework\Pages\AbstractPage;
use Symfony\Component\HttpFoundation\Request;


class Page extends AbstractPage
{
    public string $body_class = 'home';

    protected function preRender(Request $request): void
    {
        $this->title('Home - ' . (isProduction() ? 'Prod' : 'Dev'));

        $this->withScript('https://cdn.jsdelivr.net/npm/vue@3.2.6/dist/vue.global.prod.js');
        $this->withInlineScript('console.log("Hello from inline script")');

        $this->withCss('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css2');
        $this->withInlineCss('body { background-color: #FFF; color: #000; }');

        $this->renderWith([
            'heading' => 'Heading',
        ]);

        if (isProduction()) {
            $this->withBodyClass('prod');
        }
    }
}
