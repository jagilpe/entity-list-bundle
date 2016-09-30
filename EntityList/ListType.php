<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\EntityList\AbstractListType;
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
     * @see \Module7\ComponentsBundle\EntityList\ListTypeInterface::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
    }
}