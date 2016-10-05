<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

/**
 * Defines a formatter to format the contents of a cell
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
interface CellFormatterInterface
{
    /**
     * Returns the formatted value
     *
     * @param mixed $value
     *
     * @return string
     */
    public function formatValue($value);
}