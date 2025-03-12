<?php

namespace Pages\Slug;

use Phntm\Lib\Images\ResponsiveImage;
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
        $this->page->image?->configure(
            fn(ImageDriver $config): ImageDriver => $config
                ->fit(Fit::Crop, 1200, 400)
        );

        $hero = new ResponsiveImage('hero.jpg',
            config: fn(ImageDriver $config): ImageDriver => $config
                ->fit(Fit::Crop, 1216, 384)
        );

        $hero->sizes([
            '(max-width: 1024px) calc(100vw - 48px)',
            '(max-width: 1280px) calc(100vw - 64px)',
            '1216px',
        ])->srcset([
            320,
            640,
            920,
            1216,
        ]);

        $this->renderWith([
            'hero' => $hero,
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
