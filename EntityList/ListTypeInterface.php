<?php

namespace Module7\ComponentsBundle\EntityList;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface for the creation of entity lists through type classes
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
interface ListTypeInterface
{
    /**
     * Builds the entity list
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildList(EntityListBuilderInterface $builder, array $options = array());

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver);
}