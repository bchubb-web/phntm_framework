<?php

namespace Pages\Slug;

use Phntm\Lib\Model\SimplePage;
use Phntm\Lib\Db\Db;
use Phntm\Lib\Images\Responsive;
use Phntm\Lib\Infra\Routing\Attributes\Dynamic;
use Phntm\Lib\Pages\RichPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

#[Dynamic('Pages\{slug}', defaults: ['slug' => ''])]
class Page extends RichPage
{
    public function __construct(array $dynamic_params = [])
    {
        parent::__construct($dynamic_params);

        $this->registerPartResolver('page', function ($dynamic_params) {
            return SimplePage::where('slug', $dynamic_params['slug']);
        });

        $this->withScript('https://unpkg.com/@tailwindcss/browser@4');
    }

    public function __invoke(Request $request): void
    {
        $this->withBodyClass('max-w-7xl mx-auto font-sans px-4 sm:px-6 lg:px-8');

        if (!$this->page) {
            throw new ResourceNotFoundException('Page not found', 404);
        }

        $hero = new Responsive(
            location: 'phntm-1.jpeg',
            mobileFirstSizes: true
        );

        $nav = [];

        $this->renderWith([
            'heading' => $this->page->title,
            'content' => $this->page->content,
            'hero' => $hero,
            'nav' => SimplePage::where('include_in_nav', true),
        ]);
    }
}
