<?php

namespace Module7\ComponentsBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('module7_components');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('lists_theme')->defaultValue('Module7ComponentsBundle::entity_list_elements.html.twig')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
