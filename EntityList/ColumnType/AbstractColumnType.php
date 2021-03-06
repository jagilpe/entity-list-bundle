<?php

namespace Jagilpe\EntityListBundle\EntityList\ColumnType;

use Jagilpe\EntityListBundle\EntityList\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base abstract class to define list column types
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
abstract class AbstractColumnType implements ColumnTypeInterface
{
    private $optionsResolver;

    private $inheritableOptions = array(
        'translation_domain',
        'label',
    );

    /**
     * @param ColumnBuilderInterface $builder
     * @param array $options
     */
    public function build(ColumnBuilderInterface $builder, array $options = array())
    {

    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\ListTypeInterface::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'messages',
            'label' => null,
            'cell-options' => null,
            'header-options' => null,
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
        $cellOptions = $options['cell-options'];

        $inheritableOptions = $this->getInheritableOptions();

        foreach ($inheritableOptions as $inheritableOption) {
            $cellOptions[$inheritableOption] =
                isset($cellOptions[$inheritableOption])
                ? $cellOptions[$inheritableOption]
                : $options[$inheritableOption];
        }

        if (isset($cellOptions['translate_content']) && $cellOptions['translate_content']) {
            $cellOptions['translator'] = $this->translator;
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
        $headerOptions = $options['header-options'];

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