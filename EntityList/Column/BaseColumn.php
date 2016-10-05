<?php

namespace Module7\ComponentsBundle\EntityList\Column;

use Module7\ComponentsBundle\EntityList\Header\HeaderElementInterface;
use Module7\ComponentsBundle\EntityList\Cell\CellInterface;

/**
 * Base column for the use with the List Column Builder
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class BaseColumn implements ColumnInterface
{
    /**
     * @var HeaderElementInterface
     */
    protected $header;

    /**
     * @var CellInterface
     */
    protected $cell;

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::getHeader()
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::setHeader()
     */
    public function setHeader(HeaderElementInterface $header)
    {
        $this->header = $header;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::getCellContent()
     */
    public function getCellContent($entity)
    {
        return $this->cell->getCellContent($entity);
    }

    /**
     * Adds a cell element to the column
     *
     * @param CellInterface $cell
     */
    public function setCell(CellInterface $cell)
    {
        $this->cell = $cell;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnInterface::getFields()
     */
    public function getFields()
    {
        return array($this->fieldName);
    }
}