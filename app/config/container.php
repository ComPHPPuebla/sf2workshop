<?php
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\ExpressionLanguage\Expression;

$builder = new ContainerBuilder();

$builder->setParameter('routes.file_path', ['src/BookShareBundle/Resources/config']);
$builder->setParameter('routes.filename', 'routing.xml');
$builder->setParameter('routes.router_options', ['cache_dir' => 'app/cache', 'debug' => true]);

$builder->register('request')->setSynthetic(true);
$builder
    ->register('routes_file_locator', 'Symfony\Component\Config\FileLocator')
    ->addArgument('%routes.file_path%');
$builder
    ->register('routes_request_context', 'Symfony\Component\Routing\RequestContext')
    ->addMethodCall('fromRequest', [new Reference('request')]);
$builder
    ->register('routes_loader', 'Symfony\Component\Routing\Loader\XmlFileLoader')
    ->addArgument(new Reference('routes_file_locator'));
$builder
    ->register('routes_router', 'Symfony\Component\Routing\Router')
    ->setArguments([
        new Reference('routes_loader'),
        '%routes.filename%',
        '%routes.router_options%',
        new Reference('routes_request_context'),
    ]);
$builder
    ->register('kernel_router_listener', 'Symfony\Component\HttpKernel\EventListener\RouterListener')
    ->addArgument(new Expression("service('routes_router').getMatcher()"));
$builder
    ->register('kernel_error_controller', 'Framework\ErrorController');
$builder
    ->register('kernel_exception_listener', 'Symfony\Component\HttpKernel\EventListener\ExceptionListener')
    ->addArgument(new Reference('kernel_error_controller'));
$builder
    ->register('kernel_dispatcher', 'Symfony\Component\EventDispatcher\EventDispatcher')
    ->addMethodCall('addSubscriber', [new Reference('kernel_router_listener')])
    ->addMethodCall('addSubscriber', [new Reference('kernel_exception_listener')]);
$builder
    ->register('kernel_controller_resolver', 'Symfony\Component\HttpKernel\Controller\ControllerResolver');
$builder
    ->register('kernel', 'Symfony\Component\HttpKernel\HttpKernel')
    ->setArguments([new Reference('kernel_dispatcher'), new Reference('kernel_controller_resolver')]);

return $builder;
