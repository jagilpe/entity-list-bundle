<?php

namespace Module7\ComponentsBundle\EntityList\Column;

use Module7\ComponentsBundle\EntityList\Header\HeaderInterface;
use Module7\ComponentsBundle\EntityList\Cell\CellInterface;

/**
 * Defines an interface to work with the column of an entity list
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
interface ColumnInterface
{
    /**
     * Returns the Header for this column
     *
     * @return \Module7\ComponentsBundle\EntityList\Header\HeaderElementInterface
     */
    public function getHeader();

    /**
     * Returns the cell that corresponds to a determined entity
     *
     * @param mixed $entity
     *
     * @return CellInterface
     */
    public function getCellContent($entity);

    /**
     * Returns the fields included in this column
     *
     * @return array
     */
    public function getFields();
}