<?php

namespace Module7\ComponentsBundle\EntityList;

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
     * @see \Module7\ComponentsBundle\EntityList\ListTypeInterface::buildList()
     */
    public function buildList(EntityListBuilderInterface $builder, array $options = array())
    {

    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\ListTypeInterface::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'attrs' => array(),
            'label' => null,
            'translation_domain' => 'messages',
            'block_name' => null,
            'entity_class' => null,
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