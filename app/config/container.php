<?php
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use BookShareBundle\DependencyInjection\BookShareBundleExtension;
use SecurityBundle\DependencyInjection\SecurityBundleExtension;

$containerPath = 'app/cache/ProjectServiceContainer.php';

if (!file_exists($containerPath)) {
    $builder = new ContainerBuilder();
    $extension = new BookShareBundleExtension();
    $builder->registerExtension($extension);
    $builder->loadFromExtension($extension->getNamespace());
    $extension = new SecurityBundleExtension();
    $builder->registerExtension($extension);
    $builder->loadFromExtension($extension->getNamespace());

    $loader = new XmlFileLoader($builder, new FileLocator('src/Framework/Resources/config'));
    $loader->load('services.xml');

    $builder->compile();
    $dumper = new PhpDumper($builder);
    file_put_contents($containerPath, $dumper->dump());
}

require $containerPath;
$container = new ProjectServiceContainer();

return $container;
