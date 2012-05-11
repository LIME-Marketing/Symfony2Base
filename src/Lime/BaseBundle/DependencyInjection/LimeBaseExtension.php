<?php

namespace Lime\BaseBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class LimeBaseExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

//        $processor     = new Processor();
//        $configuration = new Configuration();
//        $config        = $processor->processConfiguration($configuration, $configs);
//
//        $container->setParameter('site_details', $config['site_details']);
    }
}
