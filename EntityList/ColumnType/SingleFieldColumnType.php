<?php

namespace Jagilpe\EntityListBundle\EntityList\ColumnType;

use Jagilpe\EntityListBundle\EntityList\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Jagilpe\EntityListBundle\EntityList\Header\SimpleHeaderElement;
use Jagilpe\EntityListBundle\EntityList\Cell\SingleFieldCell;
use Jagilpe\EntityListBundle\EntityList\Cell\ArrayFieldCell;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class SingleFieldColumnType extends AbstractColumnType
{
    /**
     *
     * @var TranslatorInterface
     */
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param ColumnBuilderInterface $builder
     * @param array $options
     */
    public function build(ColumnBuilderInterface $builder, array $options = array())
    {
        $fieldName = $options['field_name'] ? $options['field_name'] : $builder->getColumnName();
        $cellClass = $this->getCellClass($options);
        $builder
            ->setCell(new $cellClass($fieldName, $this->getCellOptions($options)))
            ->setHeader(new SimpleHeaderElement($fieldName, $this->getHeaderOptions($options)));
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\ListTypeInterface::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'field_name' => null,
            'multiple' => false,
        ));
    }

    /**
     * Returns the name class for the cell
     *
     * @param array $options
     * @return string
     */
    protected function getCellClass(array $options)
    {
        return $options['multiple'] ? ArrayFieldCell::class : SingleFieldCell::class;
    }
}