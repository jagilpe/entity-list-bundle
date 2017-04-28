<?php

namespace Jagilpe\EntityListBundle\EntityList;

use Jagilpe\EntityListBundle\EntityList\AbstractListType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base List Type for the List builder
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class ListType extends AbstractListType
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