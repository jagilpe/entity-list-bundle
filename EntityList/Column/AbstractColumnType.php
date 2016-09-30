<?php

namespace Module7\ComponentsBundle\EntityList\Column;

use Module7\ComponentsBundle\EntityList\Column\ColumnTypeInterface;

abstract class AbstractColumnType implements ColumnTypeInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnTypeInterface::buildColumn()
     */
    public function buildColumn(ColumnBuilderInterface $builder, array $options = array())
    {
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Column\ColumnTypeInterface::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}