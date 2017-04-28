<?php

namespace Jagilpe\EntityListBundle\EntityList;

use Jagilpe\EntityListBundle\EntityList\Header\HeaderInterface;
use Jagilpe\EntityListBundle\EntityList\Header\HeaderElementInterface;
use Jagilpe\EntityListBundle\EntityList\Cell\CellInterface;

/**
 * Defines an interface for the column builder
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
interface ColumnBuilderInterface
{
    /**
     * Adds header definition to the column
     *
     * @param \Jagilpe\EntityListBundle\EntityList\Header\HeaderElementInterface $column
     *
     * @return ColumnBuilderInterface
     */
    public function setHeader(HeaderElementInterface $header, $options = array());

    /**
     * Adds cell definition to the column
     *
     * @param \Jagilpe\EntityListBundle\EntityList\Cell\CellInterface $column
     *
     * @return ColumnBuilderInterface
     */
    public function setCell(CellInterface $cell, $options = array());

    /**
     * Returns the built entity list column
     *
     * @return \Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface
     */
    public function getListColumn();

    /**
     * Returns the name of the column
     *
     * @return string
     */
    public function getColumnName();
}