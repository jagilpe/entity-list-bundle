<?php

namespace Jagilpe\EntityListBundle\EntityList;

use Jagilpe\EntityListBundle\Exception\EntityListException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Jagilpe\EntityListBundle\EntityList\Column\BaseColumn;
use Jagilpe\EntityListBundle\EntityList\Header\HeaderElementInterface;
use Jagilpe\EntityListBundle\EntityList\Cell\CellInterface;

/**
 * Builder class to generate different Entity List Columns
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class ColumnBuilder implements ColumnBuilderInterface
{
    /**
     * @var \Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface
     */
    private $listColumn;

    public function __construct($columnName, $listColumnTypeClass = ColumnType::class, EntityListFactoryInterface $factory, array $options = array())
    {
        $columnType = $factory->getEntityListColumnType($listColumnTypeClass);

        // Get the options
        $optionsResolver = new OptionsResolver();
        $columnType->configureOptions($optionsResolver);
        $options = $optionsResolver->resolve($options);

        // Create the base entity list
        $this->listColumn = new BaseColumn($columnName);

        // Build the list
        $columnType->build($this, $options);
    }

    /**
     * Adds header definition to the column
     *
     * @param \Jagilpe\EntityListBundle\EntityList\Header\HeaderElementInterface $column
     *
     * @return ColumnBuilderInterface
     */
    public function setHeader(HeaderElementInterface $header, $options = array())
    {
        $this->listColumn->setHeader($header, $options);
        return $this;
    }

    /**
     * Adds cell definition to the column
     *
     * @param \Jagilpe\EntityListBundle\EntityList\Cell\CellInterface $column
     *
     * @return ColumnBuilderInterface
     */
    public function setCell(CellInterface $cell, $options = array())
    {
        $this->listColumn->setCell($cell, $options);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getListColumn()
    {
        return $this->listColumn;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Jagilpe\EntityListBundle\EntityList\ColumnBuilderInterface::getColumnName()
     */
    public function getColumnName()
    {
        return $this->listColumn->getColumnName();
    }

}