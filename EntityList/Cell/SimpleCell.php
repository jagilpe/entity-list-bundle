<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;

/**
 * Simple implementation of the CellInterface that simply returns the content of the field
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class SimpleCell implements CellInterface
{
    use RenderableBaseTrait;

    protected $value;

    public function __construct($value, array $options = array())
    {
        $this->value = $value;
        $this->options = $options;
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
     * Returns the value of the cell
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}