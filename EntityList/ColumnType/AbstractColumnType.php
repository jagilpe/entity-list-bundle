<?php

namespace Module7\ComponentsBundle\EntityList\ColumnType;

use Module7\ComponentsBundle\EntityList\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base abstract class to define list column types
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
abstract class AbstractColumnType
{
    /**
     *
     * @param EntityListBuilderInterface $builder
     * @param array $options
     */
    public function build(ColumnBuilderInterface $builder, array $options = array())
    {

    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\ListTypeInterface::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    /**
     * Returns the configured options resolver used for this type.
     *
     * @return \Symfony\Component\OptionsResolver\OptionsResolver The options resolver
     */
    public function getOptionsResolver()
    {
        if (null === $this->optionsResolver) {
            $this->optionsResolver = new OptionsResolver();
        }

        return $this->optionsResolver;
    }
}