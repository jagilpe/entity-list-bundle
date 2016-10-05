<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use AppBundle\Service\SettingsService;
use Module7\ComponentsBundle\Render\RenderableInterface;
use Module7\ComponentsBundle\Render\SimpleRenderableElement;

/**
 * Simple implementation of the CellInterface that simply returns the content of the field
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class SingleFieldCell extends AbstractCell
{
    /**
     *
     * @var string
     */
    protected $fieldName;

    /**
     *
     * @var CellFormatterInterface
     */
    protected $formatter;

    /**
     *
     * @var array
     */
    protected $options;

    public function __construct($fieldName, array $options = array())
    {
        $this->fieldName = $fieldName;

        if (isset($options['formatter'])) {
            if ($options['formatter'] instanceof CellFormatterInterface) {
                $this->formatter = $options['formatter'];
            }
        }

        $options['block_name'] = isset($options['block_name']) ?  $options['block_name'] : 'm7_simple_cell';

        $attributes = isset($this->options['attrs']) ? $this->options['attrs'] : array();

        if (!isset($attributes['class'])) {
            $attributes['class'] = array();
        }
        $classes = array($this->getFieldName(), 'pc-condensed');
        $attributes['class'] = array_merge($attributes['class'], $classes);

        $options['attrs'] = $attributes;

        $this->options = $options;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Cell\CellInterface::getFields()
     */
    public function getFields()
    {
        return array($this->fieldName);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Cell\CellInterface::getCellElement()
     */
    public function getCellElement($entity)
    {
        $content = array(
            'fieldName' => $this->fieldName,
            'value' => $this->getValue($entity),
        );
        return new SimpleRenderableElement($content, $this->options);
    }

    /**
     * Returns the name of the field
     *
     * @return NULL|string
     */
    public function getFieldName()
    {
        return isset($this->options['fieldName']) ? $this->options['fieldName'] : null;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getAttributes()
     */
    public function getAttributes()
    {
        $attributes = isset($this->options['attrs']) ? $this->options['attrs'] : array();

        if (!isset($attributes['class'])) {
            $attributes['class'] = array();
        }
        $classes = array($this->getFieldName(), 'pc-condensed');
        $attributes['class'] = array_merge($attributes['class'], $classes);

        return $attributes;
    }

    /**
     * Returns the value of the cell
     *
     * @param $entity
     *
     * @return string
     */
    protected function getValue($entity)
    {
        $value = $this->getFieldValue($entity);

        if ($this->formatter) {
            return $this->formatter->formatValue($value);
        }
        else {
            if ($value instanceof \DateTime) {
                $formatter = new DateTimeCellFormatter($this->getDateTimeFormat());
                return $formatter->formatValue($value);
            }
            else {
                return $value;
            }
        }
    }

    protected function getDateTimeFormat()
    {
        return isset($this->options['datetime_format'])
            ? $this->options['datetime_format']
            : SettingsService::DEFAULT_DATE_FORMAT;
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
}