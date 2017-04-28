<?php

namespace Jagilpe\EntityListBundle\EntityList;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base abstract class to implement the Entity List Types
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
abstract class AbstractListType implements ListTypeInterface
{
    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\ListTypeInterface::buildList()
     */
    public function buildList(EntityListBuilderInterface $builder, array $options = array())
    {

    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\ListTypeInterface::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'attrs' => array(),
            'label' => null,
            'label_callback' => null,
            'list' => null,
            'filter' => true,
            'translation_domain' => 'messages',
            'block_name' => null,
            'entity_class' => null,
            'column_type_options' => null,
            'pager-items-per-page' => 15,
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