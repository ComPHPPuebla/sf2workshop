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

require '../vendor/autoload.php';

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

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($router->getMatcher()));
$dispatcher->addSubscriber(new ExceptionListener(new ErrorController()));

$resolver = new ControllerResolver();
$kernel = new HttpKernel($dispatcher, $resolver);
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
