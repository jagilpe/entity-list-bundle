<?php

namespace Jagilpe\EntityListBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EntityListTypePass implements CompilerPassInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        // Check if the list factory is defined
        if (!$container->has('jgp_entity_list.list_factory')) {
            return;
        }

        $definition = $container->findDefinition('jgp_entity_list.list_factory');

        $entityListTypes = $container->findTaggedServiceIds('jgp_entity_list.list_type');

        foreach ($entityListTypes as $id => $tags) {
            $definition->addMethodCall('addEntityListType', array(new Reference($id)));
        }

        $listColumnTypes = $container->findTaggedServiceIds('jgp_entity_list.column_type');

        foreach ($listColumnTypes as $id => $tags) {
            $definition->addMethodCall('addEntityListColumnType', array(new Reference($id)));
        }
    }
}