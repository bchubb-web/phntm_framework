<?php

namespace Bchubbweb\PhntmFramework\View;

class TemplateManager 
{
    protected array $variables = [];

    protected \Twig\Environment $twig;

    protected \Twig\Loader\FilesystemLoader $loader;

    public string $view_content = '';

    public string $to_render = '';

    public function __construct(protected string $page_location)
    {
        $this->page_location = $page_location;
        // register the pages directory with the Twig loader
        $this->loader = new \Twig\Loader\FilesystemLoader( ROOT . '/pages' );
        // create a new Twig environment
        $this->twig = new \Twig\Environment($this->loader, [
            'cache' => ROOT . '/tmp/cache/twig',
            'debug' => true,
            'strict_variables' => true,
        ]);
    }
    public function render_template(string $template, array $data): string
    {
        try {
            $to_render = $this->page_location . 'view.twig';

            if (file_exists(ROOT . '/pages' .$this->page_location . '/layout.twig')) {
                $to_render = $this->page_location . '/layout.twig';
            }

            return $this->twig->render($to_render, $data);

        } catch (\Twig\Error\Error $e) {
            throw new \Exception('Twig error: ' . $e->getMessage());
        }
    }

    public function render(): string
    {
        $this->view_content = $this->twig->render($this->to_render, $this->variables);
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
