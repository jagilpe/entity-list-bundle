<?php

namespace Module7\ComponentsBundle\EntityList\Column;

use Module7\ComponentsBundle\EntityList\Header\SimpleHeaderElement;
use Module7\ComponentsBundle\EntityList\Cell\SimpleCell;
use Module7\ComponentsBundle\Exception\EntityListException;

/**
 * Defines a simple column definition that simply references a field in the Entity
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class SimpleColumn implements ColumnInterface
{
    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var array
     */
    protected $options;

    public function __construct($fieldName, array $options = array())
    {
        $this->fieldName = $fieldName;
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::isCompatibleWithEntity()
     */
    public function isCompatibleWithEntity($entityClass)
    {
        //@TODO Implement
        return true;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::getHeader()
     */
    public function getHeader()
    {
        return new SimpleHeaderElement($this->fieldName, $this->options);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::getCellContent()
     */
    public function getCellContent($entity)
    {
        return new SimpleCell($this->getFieldValue($entity));
    }

    /**
     *
     * @param unknown $entity
     */
    protected function getFieldValue($entity)
    {
        $reflectionClass = new \ReflectionClass($entity);

        $fieldName = $this->fieldName;

        $reflectionProperty = $reflectionClass->hasProperty($fieldName)
        ? $reflectionClass->getProperty($fieldName) : false;
        if ($reflectionProperty && $reflectionProperty->isPublic()) {
            return $reflectionProperty->getValue($entity);
        }

        $getterFound = false;

        foreach (array('get', 'is', 'has') as $prefix) {
            $getter = $prefix.ucfirst($fieldName);
            $reflectionMethod = $reflectionClass->getMethod($getter);

            if ($reflectionMethod && $reflectionMethod->isPublic()) {
                return $reflectionMethod->invoke($entity);
            }
        }

        throw new EntityListException("The field $fieldName does not exist or is not accessible.");
    }
}