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
class SimpleCell implements CellInterface
{
    use RenderableBaseTrait;

    /**
     *
     * @var CellFormatterInterface
     */
    protected $formatter;

    public function __construct(array $options = array())
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
        return 'm7_simple_cell';
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Cell\CellInterface::getCellElement()
     */
    public function getCellElement($entity)
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

    private function getDateTimeFormat()
    {
        return isset($this->options['datetime_format'])
            ? $this->options['datetime_format']
            : SettingsService::DEFAULT_DATE_FORMAT;
    }
}