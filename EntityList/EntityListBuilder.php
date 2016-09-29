<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\Module7ComponentsBundle;
use Module7\ComponentsBundle\EntityList\Column\ColumnInterface;

/**
 * Builder class to generate different Entity Lists
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class EntityListBuilder
{
    /**
     *
     * @var string
     */
    private $entityClass;

    /**
     * @var \Module7\ComponentsBundle\EntityList\EntityList
     */
    private $entityList;

    public function __construct($entityClass, array $entities, array $options = array())
    {
        $this->entityList = new EntityList($entityClass, $entities, $options);
    }

    /**
     * Adds a column interface definition to the List
     *
     * @param \Module7\ComponentsBundle\EntityList\Column\ColumnInterface $column
     */
    public function addColumn(ColumnInterface $column)
    {
        $this->entityList->addColumn($column);

        return $this;
    }

    /**
     * Returns the built entity list
     *
     * @return \Module7\ComponentsBundle\EntityList\EntityList
     */
    public function getEntityList()
    {
        return $this->entityList;
    }
}