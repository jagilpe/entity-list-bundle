<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Render\RenderableInterface;

/**
 * Defines an interface to work with a cell in an Entity List
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
interface CellInterface extends RenderableInterface
{
    /**
     * Returns the content of the cell to be rendered
     *
     * @param mixed $entity
     *
     * @return mixed
     */
    public function getCellContent($entity);
}