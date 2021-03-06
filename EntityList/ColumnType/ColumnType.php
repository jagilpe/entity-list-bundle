<?php

namespace Jagilpe\EntityListBundle\EntityList\ColumnType;

use Jagilpe\EntityListBundle\EntityList\ColumnType\AbstractColumnType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base column type class used by the column type builder when no other is specified
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class ColumnType extends AbstractColumnType
{
    /**
     * @var OptionsResolver
     */
    protected $optionsResolver;

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\ListTypeInterface::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
    }
}