<?php

namespace Jagilpe\EntityListBundle\EntityList;

use Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
interface EntityListFactoryInterface
{
    /**
     * Factory method to create a list builder
     *
     * @param string $entityClass
     *   The class of the entities
     * @param array $entities
     *   The entities to build the list WithComments
     * @param array $listTypeClass
     *   The list type to use
     * @param array $options
     *   The options for the entity list
     *
     * @return Jagilpe\EntityListBundle\EntityList\EntityListBuilderInterface
     */
    public function createListBuilder(array $entities, $listTypeClass = null, array $options = array());

    /**
     * Factory method to create a list from an existent list type
     *
     * @param array $entities
     * @param string $listTypeClass
     * @param array $options
     *
     * @return \Jagilpe\EntityListBundle\EntityList\EntityList
     */
    public function createList(array $entities, $listTypeClass = ListType::class, array $options = array());

    /**
     * Returns an instance of the given entity type list class
     *
     * If the type is registered as a service, returns a reference to the service
     *
     * @param string $typeClass
     *
     * @return ListTypeInterface
     */
    public function getEntityListType($typeClass);

    /**
     * Factory method to create a list column from an existent list type
     *
     * @param string $columnName
     * @param string $listTypeClass
     * @param array $options
     *
     * @return ColumnBuilderInterface
     */
    public function createListColumnBuilder($columnName, $listColumnTypeClass = null, array $options = array());

    /**
     * Factory method to create a list column from an existent list type
     *
     * @param string $columnName
     * @param string $listTypeClass
     * @param array $options
     *
     * @return ColumnInterface
     */
    public function createListColumn($columnName, $listColumnTypeClass = ColumnType::class, array $options = array());

    /**
     * Returns an instance of the given entity type list column class
     *
     * If the type is registered as a service, returns a reference to the service
     *
     * @param string $typeClass
     *
     * @return ListTypeInterface
     */
    public function getEntityListColumnType($typeClass);
}