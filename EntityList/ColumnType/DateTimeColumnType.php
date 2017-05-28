<?php

namespace Jagilpe\EntityListBundle\EntityList\ColumnType;

use Jagilpe\EntityListBundle\EntityList\Cell\DateTimeCell;

/**
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class DateTimeColumnType extends SingleFieldColumnType
{
    /**
     * Returns the name class for the cell
     *
     * @param array $options
     * @return string
     */
    protected function getCellClass(array $options)
    {
        return DateTimeCell::class;
    }
}