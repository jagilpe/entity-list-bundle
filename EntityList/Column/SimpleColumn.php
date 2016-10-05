<?php

namespace Module7\ComponentsBundle\EntityList\Column;

use Module7\ComponentsBundle\EntityList\Header\SimpleHeaderElement;
use Module7\ComponentsBundle\EntityList\Cell\SimpleCell;
use Module7\ComponentsBundle\Exception\EntityListException;
use Module7\ComponentsBundle\EntityList\Cell\CellFormatterInterface;
use Module7\ComponentsBundle\EntityList\Header\HeaderElementInterface;

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

    /**
     * @var unknown
     */
    protected $formatter;

    /**
     *
     * @var HeaderElementInterface
     */
    protected $header;

    public function __construct($fieldName, array $options = array())
    {
        $this->fieldName = $fieldName;
        $this->options = $options;

        if (isset($options['formatter'])) {
            if ($options['formatter'] instanceof CellFormatterInterface) {
                $this->formatter = $options['formatter'];
            }
        }

        $this->header = new SimpleHeaderElement($this->fieldName, $this->options);
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::getHeader()
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::setHeader()
     */
    public function setHeader(HeaderElementInterface $header)
    {
        $this->header = $header;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::getCellContent()
     */
    public function getCellContent($entity)
    {
        $options = array(
            'fieldName' => $this->fieldName,
        );

        if ($this->formatter) {
            $options['formatter'] = $this->formatter;
        }

        if (isset($this->options['datetime_format'])) {
            $options['datetime_format'] = $this->options['datetime_format'];
        }

        return new SimpleCell($this->getFieldValue($entity), $options);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::getFields()
     */
    public function getFields()
    {
        return array($this->fieldName);
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::setCell()
     */
    public function setCell(CellInterface $cell)
    {

    }

    /**
     *
     * @param unknown $entity
     */
    protected function getFieldValue($entity)
    {
        $reflectionClass = new \ReflectionClass($entity);

        $fieldName = $this->fieldName;

        // Check if this is a field of a related entity
        $fieldExplode = explode('::', $fieldName);
        if (count($fieldExplode) > 1) {
            $value = $this->getRelatedEntityValue($fieldExplode, $entity, $reflectionClass);
        }
        else {
            $reflectionProperty = $reflectionClass->hasProperty($fieldName)
            ? $reflectionClass->getProperty($fieldName) : false;
            if ($reflectionProperty && $reflectionProperty->isPublic()) {
                return $reflectionProperty->getValue($entity);
            }

            $getter = $this->getFieldGetter($reflectionClass, $fieldName);
            $value = $getter->invoke($entity);
        }

        return $value;
    }

    /**
     * Returns the Reflection Method of the getter of the field
     *
     * @param \ReflectionClass $reflectionClass
     * @param string $fieldName
     * @throws EntityListException
     * @return ReflectionMethod
     */
    protected function getFieldGetter(\ReflectionClass $reflectionClass, $fieldName)
    {
        $getterFound = false;

        foreach (array('get', 'is', 'has') as $prefix) {
            $getter = $prefix.ucfirst($fieldName);
            $reflectionMethod = $reflectionClass->getMethod($getter);

            if ($reflectionMethod && $reflectionMethod->isPublic()) {
                return $reflectionMethod;
            }
        }

        throw new EntityListException("The field $fieldName does not exist or is not accessible.");
    }

    /**
     * Returns the value of a related entity
     *
     * @param array $fieldExplode
     * @param mixed $entity
     * @return NULL
     */
    protected function getRelatedEntityValue($fieldExplode, $entity, \ReflectionClass $reflectionClass)
    {
        $value = null;

        // The value is a field of a subentity
        foreach ($fieldExplode as $subFieldName) {
            $getter = $this->getFieldGetter($reflectionClass, $subFieldName);

            $value = $getter->invoke($entity);
            if ($value) {
                if (is_object($value)) {
                    // If there are more subfields to treat this is the next entity
                    $entity = $value;
                    $reflectionClass = new \ReflectionClass($entity);
                }
            }
            else {
                // We have no value for this field
                break;
            }
        }

        return $value;
    }
}