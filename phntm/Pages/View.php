<?php

namespace Bchubbweb\PhntmFramework\Pages;

class View
{
    protected array $variables = [];

    protected \Twig\Environment $twig;

    protected \Twig\Loader\FilesystemLoader $loader;

    public string $view_content = '';

    public string $to_render = '';

    public function __construct(protected string $view_location)
    {
        $this->loader = new \Twig\Loader\FilesystemLoader( ROOT . '/pages' );
        $this->twig = new \Twig\Environment($this->loader, [
            'cache' => ROOT . '/tmp/cache/twig',
            'debug' => true,
            'strict_variables' => true,
        ]);

        try {
            $to_render = $view_location . 'view.twig';

            if (file_exists(ROOT . '/pages' .$view_location . '/layout.twig')) {
                $to_render = $view_location . '/layout.twig';
            }

            $this->to_render = $to_render;

        } catch (\Twig\Error\Error $e) {
            throw new \Exception('Twig error: ' . $e->getMessage());
        }

    }

    public function render(): string
    {
        $this->view_content = $this->twig->render($this->to_render, $this->variables);
        return $this->view_content;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->variables[$name] = $value;
    }

    protected function locateLayout(string $route): string
    {
        $current = $route;
        while (!$this->hasLayout($current) && $current !== '') {
            // remove the last part of the route
            $current = substr($current, 0, strrpos($current, '/'));
        }
        
        if (!$this->hasLayout($current)) {
            throw new \Exception('No layout found');
        }

        return ROOT . '/pages' . $route . 'layout.twig';
    }

    protected function hasLayout(string $route): bool
    {
        return file_exists(ROOT . '/pages' . $route . 'layout.twig');
    }
}
