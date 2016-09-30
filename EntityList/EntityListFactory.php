<?php

namespace Module7\ComponentsBundle\EntityList;

class EntityListFactory implements EntityListFactoryInterface
{
    /**
     * The Entity List Types registered as service
     *
     * @var array
     */
    private $listTypes;

    /**
     * {@inheritdoc}
     */
    public function createListBuilder(array $entities, $listTypeClass = null, array $options = array())
    {
        $listTypeClass = $listTypeClass !== null ? $listTypeClass : ListType::class;
        $listBuilder = new EntityListBuilder($entities, $listTypeClass, $this, $options);

        return $listBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function createList(array $entities, $listTypeClass = ListType::class, array $options = array())
    {
        $listTypeClass = $listTypeClass !== null ? $listTypeClass : ListType::class;
        return $this->createListBuilder($entities, $listTypeClass, $options)->getEntityList();
    }

    /**
     * {@inheritdoc}
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
     * Adds a Entity List Type to the list of available types registered as service
     *
     * @param ListTypeInterface $entityListType
     */
    public function addEntityListType(ListTypeInterface $entityListType)
    {
        $this->listTypes[get_class($entityListType)] = $entityListType;
    }
}