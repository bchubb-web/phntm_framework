<?php

namespace Pages\User\Id;

use Phntm\Lib\Db\Entity\Admin;
use Phntm\Lib\Pages\AbstractManagePage;
use Symfony\Component\HttpFoundation\Request;

class Manage
{
    protected string $entityClass = Admin::class;

    public function __invoke(Request $request): void
    {
        /*$this->renderWith([
            'heading' => 'Manage',
        ]);*/
    }
}
