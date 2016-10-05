<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use AppBundle\Service\SettingsService;

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

    public function __construct($fieldName, array $options = array())
    {
        $this->value = $value;
        $this->options = $options;

        if (isset($options['formatter'])) {
            if ($options['formatter'] instanceof CellFormatterInterface) {
                $this->formatter = $options['formatter'];
            }
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getBlockName()
     */
    public function getBlockName()
    {
        return 'm7_single_field_cell';
    }

    /**
     * Returns the content of the cell to be rendered
     *
     * @param mixed $entity
     *
     * @return mixed
     */
    public function getCellContent($entity)
    {

    }

    /**
     * Returns the value of the cell
     *
     * @return string
     */
    public function getValue()
    {
        if ($this->formatter) {
            return $this->formatter->formatValue($this->value);
        }
        else {
            if ($this->value instanceof \DateTime) {
                $formatter = new DateTimeCellFormatter($this->getDateTimeFormat());
                return $formatter->formatValue($this->value);
            }
            else {
                return $this->value;
            }
        }
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
}