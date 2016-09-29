<?php

namespace Module7\ComponentsBundle\EntityList;

use Namespaced\WithComments;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class EntityListFactory
{
    /**
     * Factory method to create a list builder
     *
     * @param string $entityClass
     *   The class of the entities
     * @param array $entities
     *   The entities to build the list WithComments
     * @param array $options
     *   The options for the entity list
     *
     * @return Module7\ComponentsBundle\EntityList\EntityListBuilder
     */
    public function createListBuilder($entityClass, array $entities, array $options = array())
    {
        $listBuilder = new EntityListBuilder($entityClass, $entities, $options);

        return $listBuilder;
    }
}