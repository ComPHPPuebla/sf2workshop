<?php
namespace Framework\View;

use Twig_Environment as Twig;

class TwigEngine implements TemplateEngine
{
    protected $twig;

    /**
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param  string $template
     * @param  array  $parameters
     * @return string
     */
    public function render($template, array $parameters = [])
    {
        return $this->twig->render($template, $parameters);
    }
}
