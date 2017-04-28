<?php

namespace Jagilpe\EntityListBundle\EntityList\ColumnType;

use Jagilpe\EntityListBundle\EntityList\Cell\DateTimeCell;
use Jagilpe\EntityListBundle\EntityList\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Jagilpe\EntityListBundle\EntityList\Header\SimpleHeaderElement;
use Jagilpe\EntityListBundle\EntityList\Cell\SingleFieldCell;
use Jagilpe\EntityListBundle\Exception\EntityListException;
use Jagilpe\EntityListBundle\EntityList\Cell\ArrayFieldCell;
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