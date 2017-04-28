<?php

namespace Jagilpe\EntityListBundle\EntityList\Column;

use Jagilpe\EntityListBundle\EntityList\Header\HeaderElementInterface;
use Jagilpe\EntityListBundle\EntityList\Cell\CellInterface;

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
     *
     * @var string
     */
    protected $columnName;

    public function __construct($columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface::getHeader()
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface::setHeader()
     */
    public function setHeader(HeaderElementInterface $header)
    {
        $this->header = $header;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface::getCellContent()
     */
    public function getCellElement($entity)
    {
        return $this->cell->getCellElement($entity);
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
     * @see \Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface::getFields()
     */
    public function getFields()
    {
        $fields = $this->cell->getFields();
        return $fields;
    }

    /**
     *
     * @return string
     */
    public function getColumnName()
    {
        return $this->columnName;
    }
}