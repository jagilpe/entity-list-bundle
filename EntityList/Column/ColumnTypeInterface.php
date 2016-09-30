<?php

namespace Module7\ComponentsBundle\EntityList\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
interface ColumnTypeInterface
{
    /**
     * Builds the column
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildColumn(ColumnBuilderInterface $builder, array $options = array());

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver);
}