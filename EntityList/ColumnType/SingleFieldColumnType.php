<?php

namespace Module7\ComponentsBundle\EntityList\ColumnType;

use Module7\ComponentsBundle\EntityList\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Module7\ComponentsBundle\EntityList\Header\SimpleHeaderElement;
use Module7\ComponentsBundle\EntityList\Cell\SingleFieldCell;
use Module7\ComponentsBundle\Exception\EntityListException;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class SingleFieldColumnType extends AbstractColumnType
{
    /**
     *
     * @param EntityListBuilderInterface $builder
     * @param array $options
     */
    public function build(ColumnBuilderInterface $builder, array $options = array())
    {
        $fieldName = $options['field_name'] ? $options['field_name'] : $builder->getColumnName();
        $builder
            ->setCell(new SingleFieldCell($fieldName, $this->getCellOptions($options)))
            ->setHeader(new SimpleHeaderElement($fieldName, $this->getHeaderOptions($options)));
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\ListTypeInterface::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'field_name' => null,
        ));
    }
}