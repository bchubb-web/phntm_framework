<?php

namespace Bchubbweb\PhntmFramework\View;

class TemplateManager 
{
    protected \Twig\Environment $twig;

    protected \Twig\Loader\FilesystemLoader $loader;

    protected string $view_location;

    public function __construct(protected string $page_location)
    {
        $this->loader = new \Twig\Loader\FilesystemLoader( [ROOT . '/phntm/View', PAGES] );
        $this->twig = new \Twig\Environment($this->loader, [
            'cache' => ROOT . '/tmp/cache/twig',
            'debug' => true,
            'strict_variables' => true,
        ]);

        $this->view_location = $this->page_location . 'view.twig';
    }

    public function setView(string $view): void
    {
        $this->view_location = $view;
    }

    public function renderTemplate(array $data): string
    {
        try {
            $meta = $data['phntm_meta'];
            unset($data['phntm_meta']);

            $view = $this->twig->render($this->view_location, $data);

            $document = $this->twig->render('Document.twig', [
                'head' => $meta['head'] ?? '',
                'body_class' => $meta['body_class'] ?? '',
                'view' => $view,
            ]);

            return $document;

        } catch (\Twig\Error\Error $e) {
            throw new \Exception('Twig error: ' . $e->getMessage());
        }
    }
}
