<?php

namespace Lime\BaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder() {
//        $treeBuilder = new TreeBuilder();
//        $rootNode = $treeBuilder->root('lime_base');
//        $rootNode
//            ->children()
//                ->arrayNode('site_details')
//                    ->prototype('scalar')->end()
//                ->end()
//            ->end();
//
//        return $treeBuilder;
    }
}
