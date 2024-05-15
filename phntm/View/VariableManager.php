<?php

namespace Bchubbweb\PhntmFramework\View;

class VariableManager
{
    public function __construct(protected array $variables = []){}

    public function __set(string $variable, mixed $value): void
    {
        $this->variables[$variable] = $value;
    }

    public function getAll(): array
    {
        return $this->variables;
    }
}
