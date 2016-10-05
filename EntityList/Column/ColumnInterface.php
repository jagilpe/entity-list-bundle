<?php

namespace Module7\ComponentsBundle\EntityList\Column;

use Module7\ComponentsBundle\EntityList\Header\HeaderInterface;
use Module7\ComponentsBundle\EntityList\Cell\CellInterface;
use Module7\ComponentsBundle\EntityList\Header\HeaderElementInterface;
use Module7\ComponentsBundle\Render\RenderableInterface;

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
     * Returns the cell element that corresponds to a determined entity
     *
     * @param mixed $entity
     *
     * @return RenderableInterface
     */
    public function getCellElement($entity);

    /**
     * Returns the fields included in this column
     *
     * @return array
     */
    public function getFields();

    /**
     * Adds a header element to the column
     *
     * @param HeaderElementInterface $header
     */
    public function setHeader(HeaderElementInterface $header);

    /**
     * Adds a cell element to the column
     *
     * @param CellInterface $cell
     */
    public function setCell(CellInterface $cell);

    /**
     * Returns the name of the column
     *
     * @return string
     */
    public function getColumnName();
}