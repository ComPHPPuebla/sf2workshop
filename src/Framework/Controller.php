<?php
namespace Framework;

use Symfony\Component\HttpFoundation\Response;

trait Controller
{
    public function getView()
    {
        return new View(['src/BookShareBundle/Resources/views/Book']);
    }

    public function renderResponse($template, $parameters)
    {
        $html = $this->getView()->render($template, $parameters);

        return new Response($html);
    }
}
