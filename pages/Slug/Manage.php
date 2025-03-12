<?php

namespace Pages\Slug;

use Phntm\Lib\Infra\Routing\Attributes\Dynamic;
use Phntm\Lib\Model\SimplePage;
use Phntm\Lib\Pages\Manage\InstanceEdit;

#[Dynamic('Pages\{slug}', defaults: ['slug' => ''])]
class Manage extends InstanceEdit
{
    protected ?string $backLink = '/manage/pages';

    protected string $entityClass = SimplePage::class;

    protected function resolveEntityIdentifier(): null|int|array
    {
        return ['slug' => $this->slug];
    }

    protected function handleEntityNotFound(): void
    {
        $this->entity = new $this->entityClass;
        $this->entity->slug = $this->slug;
    }
}
