<?php
namespace Framework\HttpKernel\Controller;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;
use InvalidArgumentException;

class ControllerResolver extends BaseControllerResolver
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function createController($controller)
    {
        try {
            return parent::createController($controller);
        } catch (InvalidArgumentException $e) {
            list($key, $action) = explode(':', $controller);
            if ($this->container->has($key)) {
                $controller = $this->container->get($key);
            } else {
                throw new InvalidArgumentException('Controller cannot be created');
            }
            return [$controller, $action];
        }
    }
}
