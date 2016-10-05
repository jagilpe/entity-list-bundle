<?php

namespace Module7\ComponentsBundle\EntityList\ColumnType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Module7\ComponentsBundle\EntityList\ColumnBuilderInterface;

/**
 * Interface for the creation of entity list columns through type classes
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
interface ColumnTypeInterface
{
    /**
     * Builds the entity list
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function build(ColumnBuilderInterface $builder, array $options = array());

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver);
}