<?php

namespace Jagilpe\EntityListBundle\Controller;

use Jagilpe\EntityListBundle\EntityList\ListType;

/**
 * Trait to create Entity Lists in a Controller
 *
 * @package Jagilpe\EntityListBundle\Controller
 */
trait EntityListControllerTrait
{
    /**
     * Factory method to create a list builder
     *
     * @param array $entities
     *   The entities to build the list WithComments
     * @param array $listTypeClass
     *   The list type to use
     * @param array $options
     *   The options for the entity list
     *
     * @return \Jagilpe\EntityListBundle\EntityList\EntityListBuilderInterface
     *
     * @see \Jagilpe\EntityListBundle\EntityList\EntityListFactoryInterface::createListBuilder()
     */
    protected function createEntityListBuilder(array $entities, $listTypeClass = null, array $options = array())
    {
        return $this->get('jgp_entity_list.list_factory')->createListBuilder($entities, $listTypeClass, $options);
    }

    /**
     * Factory method to create a list from an existent list type
     *
     * @param array $entities
     * @param string $listTypeClass
     * @param array $options
     *
     * @return \Jagilpe\EntityListBundle\EntityList\EntityList
     *
     * @see \Jagilpe\EntityListBundle\EntityList\EntityListFactoryInterface::createList()
     */
    protected function createEntityList(array $entities, $listTypeClass = ListType::class, array $options = array())
    {
        return $this->get('jgp_entity_list.list_factory')->createList($entities, $listTypeClass, $options);
    }
}