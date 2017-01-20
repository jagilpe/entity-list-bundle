<?php

namespace Module7\ComponentsBundle\EntityList\ColumnType;

use Module7\ComponentsBundle\EntityList\Cell\DateTimeCell;
use Module7\ComponentsBundle\EntityList\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Module7\ComponentsBundle\EntityList\Header\SimpleHeaderElement;
use Module7\ComponentsBundle\EntityList\Cell\SingleFieldCell;
use Module7\ComponentsBundle\Exception\EntityListException;
use Module7\ComponentsBundle\EntityList\Cell\ArrayFieldCell;
use Symfony\Component\Translation\TranslatorInterface;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class DateTimeColumnType extends SingleFieldColumnType
{
    /**
     * Returns the name class for the cell
     *
     * @param array $options
     * @return string
     */
    protected function getCellClass(array $options)
    {
        return DateTimeCell::class;
    }
}