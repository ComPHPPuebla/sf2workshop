<?php
namespace Framework\View;


interface TemplateEngine
{
    public function render($template, array $parameters = []);
}
