<?php

namespace Jagilpe\EntityListBundle\EntityList;

/**
 * Defines the interface for the EntityListBuilders
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
interface EntityListBuilderInterface
{
    /**
     * Adds a column interface definition to the List
     *
     * @param mixed $column
     * @param string $columnClass
     * @param array $options
     *
     * @return EntityListBuilderInterface
     */
    public function add($column, $columnClass = null, array $options = array());

    /**
     * Returns the built entity list
     *
     * @return \Jagilpe\EntityListBundle\EntityList\EntityList
     */
    public function getEntityList();
}