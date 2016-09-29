<?php

namespace Module7\ComponentsBundle\EntityList\Column;

/**
 * Defines a simple column definition that simply references a field in the Entity
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class SimpleColumn implements ColumnInterface
{
    /**
     *
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
        return isset($this->options['label']) ? $this->options['label'] : $this->fieldName;
    }
}