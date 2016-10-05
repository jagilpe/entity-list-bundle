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
abstract class AbstractColumnType implements ColumnTypeInterface
{
    private $inheritableOptions = array(
        'translation_domain',
        'label',
    );

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
            'translation_domain' => 'messages',
            'label' => null,
            'cell_options' => null,
            'header_options' => null,
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

    /**
     * Returns the options for the cell
     *
     * @param array $options
     *
     * @return array
     */
    protected function getCellOptions($options)
    {
        $cellOptions = $options['cell_options'];

        $inheritableOptions = $this->getInheritableOptions();

        foreach ($inheritableOptions as $inheritableOption) {
            $cellOptions[$inheritableOption] =
                isset($cellOptions[$inheritableOption])
                ? $cellOptions[$inheritableOption]
                : $options[$inheritableOption];
        }

        return $cellOptions;
    }

    /**
     * Returns the options for the header
     *
     * @param array $options
     *
     * @return array
     */
    protected function getHeaderOptions($options)
    {
        $headerOptions = $options['header_options'];

        $inheritableOptions = $this->getInheritableOptions();

        foreach ($inheritableOptions as $inheritableOption) {
            $headerOptions[$inheritableOption] =
                isset($headerOptions[$inheritableOption])
                ? $headerOptions[$inheritableOption]
                : $options[$inheritableOption];
        }

        return $headerOptions;
    }

    protected function getInheritableOptions()
    {
        return $this->inheritableOptions;
    }
}