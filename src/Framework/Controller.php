<?php
namespace Framework;

use Framework\View\TemplateEngine;
use Symfony\Component\HttpFoundation\Response;

trait Controller
{
    /** @var TemplateEngine */
    protected $view;

    /**
     * @param TemplateEngine $view
     */
    public function setView(TemplateEngine $view)
    {
        $this->view = $view;
    }

    /**
     * @param  string   $template
     * @param  array    $parameters
     * @return Response
     */
    public function renderResponse($template, array $parameters = [])
    {
        $html = $this->view->render($template, $parameters);

        return new Response($html);
    }
}
