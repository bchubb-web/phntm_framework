<?php

namespace Pages\Slug;

use App\Traits\PageFormSchema;
use Doctrine\ORM\EntityManager;
use Phntm\Lib\Http\Redirect;
use Phntm\Lib\Infra\Routing\Attributes\Dynamic;
use Phntm\Lib\Model;
use Phntm\Lib\Pages\AbstractManagePage;
use Phntm\Lib\Pages\Manage\InstanceEdit;
use Symfony\Component\HttpFoundation\Request;
use Phntm\Lib\Model\SimplePage;

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
