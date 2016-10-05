<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use AppBundle\Service\SettingsService;

/**
 * Abstract class to be used as base to implement the CellInterface
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
abstract class AbstractCell implements CellInterface
{
    use RenderableBaseTrait;

    /**
     * @var array
     */
    protected $options = array();

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