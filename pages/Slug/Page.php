<?php

namespace Pages\Slug;

use Phntm\Lib\Model\SimplePage;
use Phntm\Lib\Infra\Routing\Attributes\Dynamic;
use Phntm\Lib\Pages\RichPage;
use Spatie\Image\Drivers\ImageDriver;
use Spatie\Image\Enums\Fit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException as NotFound;

/** @property SimplePage $page */
#[Dynamic('Pages\{slug}', defaults: ['slug' => ''])]
class Page extends RichPage
{
    public function __invoke(Request $request): void
    {
        $this->page->image->configure(
            fn(ImageDriver $config): ImageDriver => $config
                ->fit(Fit::Crop, 1200, 400)
        );

        $this->renderWith([
            'nav' => SimplePage::where('include_in_nav', true),
        ]);

    }

    public function __construct(array $dynamic_params = [])
    {
        parent::__construct($dynamic_params);

        $this->registerPartResolver('page', function ($dynamic_params) {
            return SimplePage::where('slug', $dynamic_params['slug']);
        });

        if (!$this->page) {
            throw new NotFound('Page not found', 404);
        }

        $this->withScript('https://unpkg.com/@tailwindcss/browser@4');
    }
}
