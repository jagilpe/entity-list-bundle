<?php

namespace Jagilpe\EntityListBundle\EntityList\Cell;

/**
 * Simple implementation of the CellInterface that simply returns the content of the field
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class DateTimeCell extends SingleFieldCell
{
    /**
     *
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Cell\AbstractCell::getDefaultBlockName()
     */
    protected function getDefaultBlockName()
    {
        return 'jgp_datetime_cell';
    }
}