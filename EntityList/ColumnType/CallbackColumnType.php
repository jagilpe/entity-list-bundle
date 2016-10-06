<?php

namespace Module7\ComponentsBundle\EntityList\ColumnType;

use Module7\ComponentsBundle\EntityList\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Module7\ComponentsBundle\EntityList\Header\SimpleHeaderElement;
use Module7\ComponentsBundle\EntityList\Cell\SingleFieldCell;
use Module7\ComponentsBundle\Exception\EntityListException;
use function WebDriver\parentt;
use Module7\ComponentsBundle\EntityList\Cell\CallbackCell;

/**
 * Defines a column with cells filled with a callback
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class CallbackColumnType extends AbstractColumnType
{
    /**
     *
     * @param EntityListBuilderInterface $builder
     * @param array $options
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
     * @see \Module7\ComponentsBundle\EntityList\ListTypeInterface::configureOptions()
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
     * @see \Module7\ComponentsBundle\EntityList\ColumnType\AbstractColumnType::getCellOptions()
     */
    protected function getCellOptions($options)
    {
        $cellOptions = parent::getCellOptions($options);
        $cellOptions['content-callback'] = $options['content-callback'];

        return $cellOptions;
    }
}