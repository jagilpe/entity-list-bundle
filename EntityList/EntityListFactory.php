<?php

namespace Jagilpe\EntityListBundle\EntityList;

use Jagilpe\EntityListBundle\EntityList\ColumnType\ColumnType;
use Jagilpe\EntityListBundle\EntityList\ColumnType\ColumnTypeInterface;

class EntityListFactory implements EntityListFactoryInterface
{
    /**
     * The Entity List Types registered as service
     *
     * @var array
     */
    private $listTypes;

    /**
     * The column types registered as service
     *
     * @var array
     */
    private $columnTypes;

    /**
     *
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\EntityListFactoryInterface::createListBuilder()
     */
    public function createListBuilder(array $entities, $listTypeClass = null, array $options = array())
    {
        $listTypeClass = $listTypeClass !== null ? $listTypeClass : ListType::class;
        $listBuilder = new EntityListBuilder($entities, $listTypeClass, $this, $options);

        return $listBuilder;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\EntityListFactoryInterface::createList()
     */
    public function createList(array $entities, $listTypeClass = ListType::class, array $options = array())
    {
        $listTypeClass = $listTypeClass !== null ? $listTypeClass : ListType::class;
        return $this->createListBuilder($entities, $listTypeClass, $options)->getEntityList();
    }

    /**
     *
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\EntityListFactoryInterface::getEntityListType()
     */
    public function getEntityListType($typeClass)
    {
        if (isset($this->listTypes[$typeClass])) {
            return $this->listTypes[$typeClass];
        }
        elseif (class_exists($typeClass)) {
            return new $typeClass();
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\EntityListFactoryInterface::createListColumnBuilder()
     */
    public function createListColumnBuilder($columnName, $listColumnTypeClass = null, array $options = array())
    {
        $listColumnTypeClass = $listColumnTypeClass !== null ? $listColumnTypeClass : ColumnType::class;
        $listBuilder = new ColumnBuilder($columnName, $listColumnTypeClass, $this, $options);

        return $listBuilder;
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\EntityListFactoryInterface::createListColumn()
     */
    public function createListColumn($columnName, $listColumnTypeClass = ColumnType::class, array $options = array())
    {
        $listColumnBuilder = $this->createListColumnBuilder($columnName, $listColumnTypeClass, $options);
        return $listColumnBuilder->getListColumn();
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\EntityListFactoryInterface::getEntityListColumnType()
     */
    public function getEntityListColumnType($columnTypeClass)
    {
        if (isset($this->columnTypes[$columnTypeClass])) {
            return $this->columnTypes[$columnTypeClass];
        }
        elseif (class_exists($columnTypeClass)) {
            return new $columnTypeClass();
        }
    }

    /**
     * Adds a Entity List Type to the list of available types registered as service
     *
     * @param ListTypeInterface $entityListType
     */
    public function addEntityListType(ListTypeInterface $entityListType)
    {
        $this->listTypes[get_class($entityListType)] = $entityListType;
    }

    /**
     * Adds a Entity List Type to the list of available types registered as service
     *
     * @param ListTypeInterface $entityListType
     */
    public function addEntityListColumnType(ColumnTypeInterface $entityListColumnType)
    {
        $this->columnTypes[get_class($entityListColumnType)] = $entityListColumnType;
    }
}