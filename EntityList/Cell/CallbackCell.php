<?php

namespace Jagilpe\EntityListBundle\EntityList\Cell;

use Jagilpe\EntityListBundle\Exception\EntityListException;

/**
 * Simple implementation of the CellInterface that uses a callback to return the content of the cell
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class CallbackCell extends AbstractCell
{
    /**
     * @var callable
     */
    protected $contentCallback;

    public function __construct($fieldName, array $options = array())
    {
        parent::__construct($fieldName, $options);

        if (isset($options['content-callback']) && is_callable($options['content-callback'])) {
            $this->contentCallback = $options['content-callback'];
        }
        else {
            throw new EntityListException('The option content-callback is required and must be callable.');
        }

        $this->options = array_merge($this->options, $options);
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Cell\CellInterface::getFields()
     */
    public function getFields()
    {
        return $this->getFieldName() ? array($this->getFieldName()) : array();
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Cell\CellInterface::getCellElement()
     */
    public function getCellContent($entity)
    {
        return $this->getFieldValue($entity);
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Cell\AbstractCell::getDefaultBlockName()
     */
    protected function getDefaultBlockName()
    {
        return 'jgp_simple_cell';
    }

    /**
     * {@inheritDoc}
     */
    protected function getFieldValue($entity)
    {
        return call_user_func($this->contentCallback, $entity);
    }
}