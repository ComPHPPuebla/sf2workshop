<?php
namespace SecurityBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SecurityBundleExtension extends Extension
{
    /**
     * @param array            $config
     * @param ContainerBuilder $builder
     */
    public function load(array $config, ContainerBuilder $builder)
    {
        $loader = new XmlFileLoader(
            $builder, new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.xml');
    }
}
