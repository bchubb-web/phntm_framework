<?php

namespace Bchubbweb\PhntmFramework\View;

class TemplateManager 
{
    protected \Twig\Environment $twig;

    protected \Twig\Loader\FilesystemLoader $loader;

    public function __construct(protected string $page_location)
    {
        $this->loader = new \Twig\Loader\FilesystemLoader( ROOT . '/pages' );
        $this->twig = new \Twig\Environment($this->loader, [
            'cache' => ROOT . '/tmp/cache/twig',
            'debug' => true,
            'strict_variables' => true,
        ]);
    }
    public function renderTemplate(string $template, array $data): string
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

    // TODO make this work
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
