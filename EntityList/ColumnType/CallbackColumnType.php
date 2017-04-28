<?php

namespace Jagilpe\EntityListBundle\EntityList\ColumnType;

use Jagilpe\EntityListBundle\EntityList\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Jagilpe\EntityListBundle\EntityList\Header\SimpleHeaderElement;
use Jagilpe\EntityListBundle\EntityList\Cell\SingleFieldCell;
use Jagilpe\EntityListBundle\Exception\EntityListException;
use function WebDriver\parentt;
use Jagilpe\EntityListBundle\EntityList\Cell\CallbackCell;

/**
 * Defines a column with cells filled with a callback
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class CallbackColumnType extends AbstractColumnType
{
    /**
     *
     * @param ColumnBuilderInterface $builder
     * @param array $options
     *
     * @throws EntityListException
     */
    public function build(ColumnBuilderInterface $builder, array $options = array())
    {
        $fieldName = $options['field_name'] ? $options['field_name'] : $builder->getColumnName();

        if (!$options['content-callback'] || !is_callable($options['content-callback'])) {
            throw new EntityListException('The option content-callback must be defined and callable.');
        }

        $builder
            ->setCell(new CallbackCell($fieldName, $this->getCellOptions($options)))
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
            'content-callback' => null,
        ));
    }

    /**
     *
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\ColumnType\AbstractColumnType::getCellOptions()
     */
    protected function getCellOptions($options)
    {
        $cellOptions = parent::getCellOptions($options);
        $cellOptions['content-callback'] = $options['content-callback'];

        return $cellOptions;
    }
}