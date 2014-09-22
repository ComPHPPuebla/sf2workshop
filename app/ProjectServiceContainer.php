<?php

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * ProjectServiceContainer
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class ProjectServiceContainer extends Container
{
    private $parameters;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services =
        $this->scopedServices =
        $this->scopeStacks = array();

        $this->set('service_container', $this);

        $this->scopes = array();
        $this->scopeChildren = array();
        $this->methodMap = array(
            'kernel' => 'getKernelService',
            'kernel_controller_resolver' => 'getKernelControllerResolverService',
            'kernel_dispatcher' => 'getKernelDispatcherService',
            'kernel_error_controller' => 'getKernelErrorControllerService',
            'kernel_exception_listener' => 'getKernelExceptionListenerService',
            'kernel_router_listener' => 'getKernelRouterListenerService',
            'request' => 'getRequestService',
            'routes_file_locator' => 'getRoutesFileLocatorService',
            'routes_loader' => 'getRoutesLoaderService',
            'routes_request_context' => 'getRoutesRequestContextService',
            'routes_router' => 'getRoutesRouterService',
        );

        $this->aliases = array();
    }

    /**
     * Gets the 'kernel' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpKernel\HttpKernel A Symfony\Component\HttpKernel\HttpKernel instance.
     */
    protected function getKernelService()
    {
        return $this->services['kernel'] = new \Symfony\Component\HttpKernel\HttpKernel($this->get('kernel_dispatcher'), $this->get('kernel_controller_resolver'));
    }

    /**
     * Gets the 'kernel_controller_resolver' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpKernel\Controller\ControllerResolver A Symfony\Component\HttpKernel\Controller\ControllerResolver instance.
     */
    protected function getKernelControllerResolverService()
    {
        return $this->services['kernel_controller_resolver'] = new \Symfony\Component\HttpKernel\Controller\ControllerResolver();
    }

    /**
     * Gets the 'kernel_dispatcher' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\EventDispatcher\EventDispatcher A Symfony\Component\EventDispatcher\EventDispatcher instance.
     */
    protected function getKernelDispatcherService()
    {
        $this->services['kernel_dispatcher'] = $instance = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $instance->addSubscriber($this->get('kernel_router_listener'));
        $instance->addSubscriber($this->get('kernel_exception_listener'));

        return $instance;
    }

    /**
     * Gets the 'kernel_error_controller' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Framework\ErrorController A Framework\ErrorController instance.
     */
    protected function getKernelErrorControllerService()
    {
        return $this->services['kernel_error_controller'] = new \Framework\ErrorController();
    }

    /**
     * Gets the 'kernel_exception_listener' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpKernel\EventListener\ExceptionListener A Symfony\Component\HttpKernel\EventListener\ExceptionListener instance.
     */
    protected function getKernelExceptionListenerService()
    {
        return $this->services['kernel_exception_listener'] = new \Symfony\Component\HttpKernel\EventListener\ExceptionListener($this->get('kernel_error_controller'));
    }

    /**
     * Gets the 'kernel_router_listener' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\HttpKernel\EventListener\RouterListener A Symfony\Component\HttpKernel\EventListener\RouterListener instance.
     */
    protected function getKernelRouterListenerService()
    {
        return $this->services['kernel_router_listener'] = new \Symfony\Component\HttpKernel\EventListener\RouterListener($this->get("routes_router")->getMatcher());
    }

    /**
     * Gets the 'request' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @throws RuntimeException always since this service is expected to be injected dynamically
     */
    protected function getRequestService()
    {
        throw new RuntimeException('You have requested a synthetic service ("request"). The DIC does not know how to construct this service.');
    }

    /**
     * Gets the 'routes_file_locator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Config\FileLocator A Symfony\Component\Config\FileLocator instance.
     */
    protected function getRoutesFileLocatorService()
    {
        return $this->services['routes_file_locator'] = new \Symfony\Component\Config\FileLocator(array(0 => 'src/BookShareBundle/Resources/config'));
    }

    /**
     * Gets the 'routes_loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Routing\Loader\XmlFileLoader A Symfony\Component\Routing\Loader\XmlFileLoader instance.
     */
    protected function getRoutesLoaderService()
    {
        return $this->services['routes_loader'] = new \Symfony\Component\Routing\Loader\XmlFileLoader($this->get('routes_file_locator'));
    }

    /**
     * Gets the 'routes_request_context' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Routing\RequestContext A Symfony\Component\Routing\RequestContext instance.
     */
    protected function getRoutesRequestContextService()
    {
        $this->services['routes_request_context'] = $instance = new \Symfony\Component\Routing\RequestContext();

        $instance->fromRequest($this->get('request'));

        return $instance;
    }

    /**
     * Gets the 'routes_router' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return Symfony\Component\Routing\Router A Symfony\Component\Routing\Router instance.
     */
    protected function getRoutesRouterService()
    {
        return $this->services['routes_router'] = new \Symfony\Component\Routing\Router($this->get('routes_loader'), 'routing.xml', array('cache_dir' => 'app/cache', 'debug' => true), $this->get('routes_request_context'));
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        $name = strtolower($name);

        if (!(isset($this->parameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        $name = strtolower($name);

        return isset($this->parameters[$name]) || array_key_exists($name, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    /**
     * {@inheritdoc}
     */
    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $this->parameterBag = new FrozenParameterBag($this->parameters);
        }

        return $this->parameterBag;
    }
    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'routes.file_path' => array(
                0 => 'src/BookShareBundle/Resources/config',
            ),
            'routes.filename' => 'routing.xml',
            'routes.router_options' => array(
                'cache_dir' => 'app/cache',
                'debug' => true,
            ),
        );
    }
}
