<?php

namespace App\Traits;

trait PageFormSchema
{
    public function formSchema(): array
    {
        return [
            [
                'element' => 'input',
                'label' => 'Page Title',
                'attributes' => [
                    'id' => 'title',
                    'type' => 'text',
                    'name' => 'title',
                    'required' => true,
                ],
            ],
            [
                'element' => 'textarea',
                'label' => 'Page Content',
                'attributes' => [
                    'id' => 'content',
                    'name' => 'content',
                    'required' => true,
                ],
            ],
        ];
    }
}
