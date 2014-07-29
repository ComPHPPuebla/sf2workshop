<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Framework\ErrorController;

chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

function render_response($template, array $parameters = [])
{
    ob_start();
    extract($parameters, EXTR_SKIP);
    require "src/BookShareBundle/Resources/views/Book/$template";

    return new Response(ob_get_clean());
}

$request = Request::createFromGlobals();

$container = require 'app/config/container.php';
$container->set('request', $request);

$kernel = $container->get('kernel');

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
