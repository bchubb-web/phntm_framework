<?php

namespace Bchubbweb\PhntmFramework\Pages;

use Bchubbweb\PhntmFramework\View\TemplateManager;
use Bchubbweb\PhntmFramework\Pages\PageInterface;
use Bchubbweb\PhntmFramework\Router;
use Nyholm\Psr7\Stream;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractPage implements PageInterface
{
    use Meta;

    protected array $view_variables = [];

    protected string $default_view = 'view.twig';

    /**
     * AbstractPage constructor.
     *
     * @param array $dynamic_params
     */
    public function __construct(protected array $dynamic_params = [])
    {
        // get view.twig relative to the root of the pages folder
        $this->default_view = Router::r2p(Router::n2r(static::class)) . '/view.twig';
    }

    abstract protected function preRender(Request $request): void;

    final public function render($request): StreamInterface
    {

        $relative_template_location = Router::n2r(static::class);

        $relative_template_location = explode('/', $relative_template_location);
        $relative_template_location = implode('/', array_map('ucfirst', $relative_template_location)) . '/';

        static::preRender($request);

        // no file to render, respond 204
        if (!file_exists(ROOT . '/pages' . $relative_template_location . 'view.twig')) {
            return Stream::create('');
        }

        $template_manager = new TemplateManager($relative_template_location);

        $body = $template_manager->renderTemplate([
            ...$this->view_variables, 
            'content' => $this->default_view, 
            'phntm_meta' => $this->getMeta()
        ]);

        return Stream::create($body);
    }

    /**
     * Set the view to be used on render
     * relative to the root of the pages directory, or previx with ./ for the current directory
     * TODO                                            ^^^
     * 
     * @param string $view
     */
    public function setView(string $view): void
    {
        if (strpos($view, './') === 0) {
            $view = Router::r2p(Router::n2r(static::class)) . '/' . substr($view, 2);
        }
        $this->default_view = $view;
    }

    protected function updateTemplate(string $template, array $data): void
    {
        $this->view->updateTemplate($template, $data);
    }

    public function __get(string $name): mixed
    {
        if (array_key_exists($name, $this->dynamic_params)) {
            return $this->dynamic_params[$name];
        }
        return null;
    }

    final public function renderWith(array $variables): void
    {
        $this->view_variables = array_merge($this->view_variables, $variables);
    }
}
