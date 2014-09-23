<?php
namespace Framework;

use Symfony\Component\HttpFoundation\Response;

trait Controller
{
    /** @var View */
    protected $view;

    /**
     * @param View $view
     */
    public function setView(View $view)
    {
        $this->view = $view;
    }

    /**
     * @param  string   $template
     * @param  array    $parameters
     * @return Response
     */
    public function renderResponse($template, $parameters = [])
    {
        $html = $this->view->render($template, $parameters);

        return new Response($html);
    }
}
