<?php

namespace Lime\ProfilerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Alex Kleissner <hex337@gmail.com>
 */
class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\DependencyInjection\Configuration\NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('lime_profiler');

        $rootNode
            ->children()
//                ->scalarNode('location_config')->defaultValue('/opt/local/www/php5-xhprof/xhprof_lib/config.php')->end()
//                ->scalarNode('location_lib')->defaultValue('/opt/local/www/php5-xhprof/xhprof_lib/utils/xhprof_lib.php')->end()
//                ->scalarNode('location_runs')->defaultValue('/opt/local/www/php5-xhprof/xhprof_lib/utils/xhprof_runs.php')->end()
                ->scalarNode('location_reports')->defaultNull()->end()
                ->scalarNode('enabled')->defaultFalse()->end()
            ->end();

        return $treeBuilder->buildTree();
    }
}
