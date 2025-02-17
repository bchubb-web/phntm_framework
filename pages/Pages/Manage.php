<?php

namespace Pages\Pages;

use Phntm\Lib\Model;
use Phntm\Lib\Pages\Manage\Listing;
use Phntm\Lib\Model\SimplePage;

class Manage extends Listing
{
    protected string $entityClass = SimplePage::class;

    protected string $editLink = '/manage/{slug}';

    protected array $tableActions = [
        [
            'action' => 'edit',
            'label' => 'Edit',
            'class' => 'text-orange-600 hover:text-orange-900',
        ]
    ];

    protected function resolveEditUrl(Model $entity): string
    {
        return '/manage/' . $entity->slug;
    }
}
