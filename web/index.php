<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

require '../vendor/autoload.php';

function render_response($template, array $parameters = [])
{
    ob_start();
    extract($parameters, EXTR_SKIP);
    require "../src/BookShareBundle/Resources/views/Book/$template";

    return new Response(ob_get_clean());
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

try {
    $parameters = $router->match($request->getPathInfo());
    $request->attributes->add($parameters);

    $response = call_user_func_array($parameters['_controller'], [$request]);

} catch (ResourceNotFoundException $exception) {
    $response = new Response('The page you are looking for does not exist.');
    $response->setStatusCode(404);
} catch (Exception $exception) {
    $response = new Response('Something went terribly wrong.');
    $response->setStatusCode(500);
} finally {
    $response->prepare($request);
    $response->send();
}
