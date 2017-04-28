<?php

namespace Jagilpe\EntityListBundle\EntityList\Cell;

use Jagilpe\EntityListBundle\Render\RenderableInterface;

/**
 * Defines an interface to work with a cell in an Entity List
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
interface CellInterface
{
    /**
     * Returns the content of the cell to be rendered
     *
     * @param mixed $entity
     *
     * @return RenderableInterface
     */
    public function getCellElement($entity);

    /**
     * Returns the fields referenced in this cell
     *
     * @return array
     */
    public function getFields();
}