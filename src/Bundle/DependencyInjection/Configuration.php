<?php

declare(strict_types=1);

namespace Optime\PentahoReport\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('optime_pentaho_report');
        $rootNode    = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
