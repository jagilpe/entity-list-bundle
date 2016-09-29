<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\Module7ComponentsBundle;
use Module7\ComponentsBundle\EntityList\Column\ColumnInterface;
use Module7\ComponentsBundle\Exception\EntityListException;

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
    public function add($column, $columnClass = null, $options = array())
    {
        if (!($column instanceof ColumnInterface)) {
            $column = $this->createColumn($column, $columnClass, $options);
        }

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

    private function createColumn($columnName, $columnClass, $columnOptions = array())
    {
        if ($columnClass === null) {
            throw new EntityListException('Not enough parameters to create a column');
        }

        if (!class_exists($columnClass)) {
            throw new EntityListException("Class $columnClass does not exist.");
        }

        $reflectionClass = new \ReflectionClass($columnClass);
        if (!$reflectionClass->implementsInterface(ColumnInterface::class)) {
            throw new EntityListException('The columns class parameter must implement the '.ColumnInterface::class.' interface.');
        }

        return $reflectionClass->newInstance($columnName, $columnOptions);
    }
}