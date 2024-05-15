<?php

namespace Bchubbweb\PhntmFramework\Pages;

use Bchubbweb\PhntmFramework\View\TemplateManager;
use Bchubbweb\PhntmFramework\View\VariableManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Bchubbweb\PhntmFramework\Pages\PageInterface;
use Bchubbweb\PhntmFramework\Router;

abstract class AbstractPage implements PageInterface
{
    protected VariableManager $variables;

    public function __construct()
    {
        $this->variables = new VariableManager();
    }

    abstract protected function preRender(Request $request): ?Response;

    public function render($request): Response
    {

        $relative_template_location = Router::n2r(static::class);

        $relative_template_location = explode('/', $relative_template_location);
        $relative_template_location = implode('/', array_map('ucfirst', $relative_template_location)) . '/';

        if (!file_exists(ROOT . '/pages' . $relative_template_location . 'view.twig')) {
            throw new \Exception('Template not found');
        }
        $template_manager = new TemplateManager($relative_template_location);

        $response = static::preRender($request);

        if (is_null($response)) {
            $response = new Response();
        }

        return $response->setContent(
            $template_manager->render_template('view.twig', $this->variables->getAll())
        );
    }

    protected function updateTemplate(string $template, array $data): void
    {
        $this->view->updateTemplate($template, $data);
    }
}
