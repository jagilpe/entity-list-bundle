<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\Exception\EntityListException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Module7\ComponentsBundle\EntityList\Column\BaseColumn;
use Module7\ComponentsBundle\EntityList\Header\HeaderElementInterface;
use Module7\ComponentsBundle\EntityList\Cell\CellInterface;

/**
 * Builder class to generate different Entity List Columns
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class ColumnBuilder implements ColumnBuilderInterface
{
    /**
     * @var \Module7\ComponentsBundle\EntityList\Column\ColumnInterface
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
     * @param \Module7\ComponentsBundle\EntityList\Header\HeaderElementInterface $column
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
     * @param \Module7\ComponentsBundle\EntityList\Cell\CellInterface $column
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
     * @see \Module7\ComponentsBundle\EntityList\ColumnBuilderInterface::getColumnName()
     */
    public function getColumnName()
    {
        return $this->listColumn->getColumnName();
    }

}