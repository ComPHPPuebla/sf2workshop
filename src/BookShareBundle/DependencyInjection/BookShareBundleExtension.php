<?php
namespace BookShareBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class BookShareBundleExtension extends Extension
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
