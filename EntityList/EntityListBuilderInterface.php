<?php

namespace Module7\ComponentsBundle\EntityList;

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
     * @param \Module7\ComponentsBundle\EntityList\Column\ColumnInterface $column
     */
    public function add($column, $columnClass = null, $options = array());

    /**
     * Returns the built entity list
     *
     * @return \Module7\ComponentsBundle\EntityList\EntityList
     */
    public function getEntityList();
}