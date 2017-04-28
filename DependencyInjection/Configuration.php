<?php

namespace Jagilpe\EntityListBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jagilpe_components');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('lists_theme')->defaultValue('JagilpeEntityListBundle::entity_list_elements.html.twig')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
