<?php

namespace Bchubbweb\PhntmFramework\Pages;

trait Meta
{
    public string $body_class = '';

    protected array $body_classes = [];

    protected string $title = 'Change me';

    protected function title(string $title): void
    {
        $this->title = $title;
    }

    protected  function head(): string
    {
        return "<title>{$this->title}</title>";
    }

    protected function withBodyClass(string $class): void
    {
        if (!in_array($class, $this->body_classes)) {
            $this->body_classes[] = $class;
        }
    }

    protected function bodyClasses(): string
    {
        return implode(' ', [ $this->body_class, ...$this->body_classes ]);
    }

    final public function getMeta(): array
    {
        return [
            'head' => $this->head(),
            'body_class' => $this->bodyClasses(),
        ];
    }
}
