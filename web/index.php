<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Router;

require '../vendor/autoload.php';

function render_template($template, array $result)
{
    ob_start();
    extract($result, EXTR_SKIP);
    require "../src/BookShareBundle/Resources/views/Book/$template.phtml";

    return ob_get_clean();
}

$request = Request::createFromGlobals();

$locator = new FileLocator(['../src/BookShareBundle/Resources/config']);

$context = new RequestContext();
$context->fromRequest($request);

$router = new Router(
    new XmlFileLoader($locator),
    'routing.xml',
    ['cache_dir' => '../app/cache', 'debug' => true],
    $context
);

$parameters = $router->match($request->getPathInfo());
$request->attributes->add($parameters);

$result = call_user_func_array($parameters['_controller'], [$request]);
$html = render_template($parameters['_route'], $result);

$response = new Response($html);
$response->prepare($request);
$response->send();
