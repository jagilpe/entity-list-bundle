<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\EntityList\Header\HeaderInterface;
use Module7\ComponentsBundle\EntityList\Header\HeaderElementInterface;
use Module7\ComponentsBundle\EntityList\Cell\CellInterface;

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
     * @param \Module7\ComponentsBundle\EntityList\Header\HeaderElementInterface $column
     */
    public function setHeader(HeaderElementInterface $header, $options = array());

    /**
     * Adds cell definition to the column
     *
     * @param \Module7\ComponentsBundle\EntityList\Cell\CellInterface $column
     */
    public function setCell(CellInterface $cell, $options = array());

    /**
     * Returns the built entity list column
     *
     * @return \Module7\ComponentsBundle\EntityList\Column\ColumnInterface
     */
    public function getListColumn();
}