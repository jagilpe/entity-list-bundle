<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\EntityList\ColumnType\ColumnType;

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
     * @see \Module7\ComponentsBundle\EntityList\EntityListFactoryInterface::createListBuilder()
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
     * @see \Module7\ComponentsBundle\EntityList\EntityListFactoryInterface::createList()
     */
    public function createList(array $entities, $listTypeClass = ListType::class, array $options = array())
    {
        $listTypeClass = $listTypeClass !== null ? $listTypeClass : ListType::class;
        return $this->createListBuilder($entities, $listTypeClass, $options)->getEntityList();
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\EntityListFactoryInterface::getEntityListType()
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
     * @see \Module7\ComponentsBundle\EntityList\EntityListFactoryInterface::createListColumnBuilder()
     */
    public function createListColumnBuilder($listColumnTypeClass = null, array $options = array())
    {
        $listColumnTypeClass = $listColumnTypeClass !== null ? $listColumnTypeClass : ColumnType::class;
        $listBuilder = new ColumnBuilder($listColumnTypeClass, $this, $options);
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\EntityListFactoryInterface::createListColumn()
     */
    public function createListColumn($listColumnTypeClass = ColumnType::class, array $options = array())
    {
        $listColumnType = $this->getEntityListColumnType($listColumnTypeClass);
        return $listColumnType->getListColumn();
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\EntityListFactoryInterface::getEntityListColumnType()
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
    public function addEntityListColumnType(ColumnTypeInterface $entityListColumnType)
    {
        $this->columnTypes[get_class($entityListColumnType)] = $entityListColumnType;
    }
}