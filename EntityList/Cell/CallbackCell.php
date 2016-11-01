<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use AppBundle\Service\SettingsService;
use Module7\ComponentsBundle\Render\RenderableInterface;
use Module7\ComponentsBundle\Render\SimpleRenderableElement;
use Module7\ComponentsBundle\Exception\EntityListException;

/**
 * Simple implementation of the CellInterface that uses a callback to return the content of the cell
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class CallbackCell extends AbstractCell
{
    /**
     *
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

        $this->options = $options;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Cell\CellInterface::getFields()
     */
    public function getFields()
    {
        return $this->getFieldName() ? array($this->getFieldName()) : array();
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Cell\CellInterface::getCellElement()
     */
    public function getCellElement($entity)
    {
        $content = array(
            'fieldName' => $this->fieldName,
            'value' => call_user_func($this->contentCallback, $entity),
        );
        return new SimpleRenderableElement($content, $this->options);
    }

    protected function getDefaultBlockName()
    {
        return 'm7_simple_cell';
    }
}