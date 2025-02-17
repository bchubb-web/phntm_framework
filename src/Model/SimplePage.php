<?php

namespace App\Model;

use DateTime;
use Phntm\Lib\Model;
use Phntm\Lib\Model\Attribute as Col;
use function ltrim;

class SimplePage 
{
    protected static string $table = 'simple_pages';

    #[Col\Text(
        required: true,
    )]
    public string $title;

    #[Col\Text(
        required: true,
        unique: true,
    )]
    public string $slug;

    #[Col\TextArea(
        required: true,
    )]
    public string $content;

    #[Col\Date(
        label: 'Date Published',
        required: false,
    )]
    public ?\DateTime $published_on;

    #[Col\Boolean(
        label: 'Include in navigation?',
        required: false,
    )]
    public ?bool $include_in_nav;

    public static function getTableColumns(): array
    {
        return [
            'title',
            'slug',
            'published_on',
        ];
    }
}
