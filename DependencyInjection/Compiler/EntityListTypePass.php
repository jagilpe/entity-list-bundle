<?php

namespace Module7\ComponentsBundle\DependencyInjection\Compiler;

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
        if (!$container->has('m7_components.list_factory')) {
            return;
        }

        $definition = $container->findDefinition('m7_components.list_factory');

        $entityListTypes = $container->findTaggedServiceIds('m7_components.list_type');

        foreach ($entityListTypes as $id => $tags) {
            $definition->addMethodCall('addEntityListType', array(new Reference($id)));
        }

        $listColumnTypes = $container->findTaggedServiceIds('m7_components.column_type');

        foreach ($listColumnTypes as $id => $tags) {
            $definition->addMethodCall('addEntityListColumnType', array(new Reference($id)));
        }
    }
}