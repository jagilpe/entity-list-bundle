<?php

namespace Module7\ComponentsBundle\EntityList\Header;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;

/**
 * Simple implementation of the Header Element
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class SimpleHeaderElement implements HeaderElementInterface
{
    use RenderableBaseTrait;

    protected $fieldName;

    public function __construct($fieldName, array $options = array())
    {
        $this->fieldName = $fieldName;
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getWidget()
     */
    public function getBlockName()
    {
        return 'm7_simple_header_element';
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getLabel()
     */
    public function getLabel()
    {
        return isset($this->options['label']) ? $this->options['label'] : $this->getFieldName();
    }

    /**
     * Returns the name that corresponds with this column
     *
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }
}