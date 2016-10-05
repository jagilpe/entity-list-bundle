<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\EntityList\Column\ColumnInterface;
use Module7\ComponentsBundle\Exception\EntityListException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Module7\ComponentsBundle\EntityList\ColumnType\ColumnTypeInterface;

/**
 * Builder class to generate different Entity Lists
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class EntityListBuilder implements EntityListBuilderInterface
{
    /**
     * @var \Module7\ComponentsBundle\EntityList\EntityList
     */
    private $entityList;

    private $factory;

    public function __construct(array $entities, $listTypeClass = ListType::class, EntityListFactoryInterface $factory, array $options = array())
    {
        $entityType = $factory->getEntityListType($listTypeClass);
        $this->factory = $factory;

        // Get the options
        $optionsResolver = new OptionsResolver();
        $entityType->configureOptions($optionsResolver);
        $options = $optionsResolver->resolve($options);

        // Create the base entity list
        $this->entityList = new EntityList($entities, $options);

        // Build the list
        $entityType->buildList($this, $options);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\EntityListBuilderInterface::add()
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
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\EntityListBuilderInterface::getEntityList()
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
        if ($reflectionClass->implementsInterface(ColumnInterface::class)) {
            $column = $reflectionClass->newInstance($columnName, $columnOptions);
        }
        elseif ($reflectionClass->implementsInterface(ColumnTypeInterface::class)) {
            $column = $this->factory->createListColumn($columnName, $columnClass, $columnOptions);
        }
        else {
            throw new EntityListException('Wrong class');
        }

        return $column;
    }
}