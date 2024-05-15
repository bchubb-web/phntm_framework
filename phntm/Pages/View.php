<?php

namespace Bchubbweb\PhntmFramework\Pages;

class View
{
    protected array $variables = [];

    public function __set(string $name, mixed $value): void
    {
        $this->variables[$name] = $value;
    }

    public function load(string $template): bool
    {
        $path = debug_backtrace()[1]['file'];

        $loader = new \Twig\Loader\FilesystemLoader(dirname($path));
        $twig = new \Twig\Environment($loader, [
            'cache' => ROOT . '/tmp/cache/twig',
            'debug' => true,
            'strict_variables' => true,
        ]);

        try {
            $renderContent = $twig->render($template, $this->variables);
        } catch (\Twig\Error\LoaderError $e) {
            return false;
        }

        return true;
    }

    protected function locateLayout(string $route): string
    {
        $current = $route;
        while (!$this->hasLayout($current) && $current !== '') {
            // remove the last part of the route
            echo $current . PHP_EOL;
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
