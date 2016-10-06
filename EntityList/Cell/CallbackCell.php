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
     * @var string
     */
    protected $fieldName;

    /**
     *
     * @var array
     */
    protected $options;

    /**
     *
     * @var callable
     */
    protected $contentCallback;

    public function __construct($fieldName, array $options = array())
    {
        $this->fieldName = $fieldName;

        if (isset($options['formatter'])) {
            if ($options['formatter'] instanceof CellFormatterInterface) {
                $this->formatter = $options['formatter'];
            }
        }

        if (isset($options['content-callback']) && is_callable($options['content-callback'])) {
            $this->contentCallback = $options['content-callback'];
        }
        else {
            throw new EntityListException('The option content-callback is required and must be callable.');
        }

        $options['block_name'] = isset($options['block_name']) ?  $options['block_name'] : 'm7_simple_cell';

        $attributes = isset($this->options['attrs']) ? $this->options['attrs'] : array();

        if (!isset($attributes['class'])) {
            $attributes['class'] = array();
        }
        $classes = array($this->getFieldName(), 'pc-condensed');
        $attributes['class'] = array_merge($attributes['class'], $classes);

        $options['attrs'] = $attributes;

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

    /**
     * Returns the name of the field
     *
     * @return NULL|string
     */
    public function getFieldName()
    {
        return isset($this->options['fieldName']) ? $this->options['fieldName'] : null;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getAttributes()
     */
    public function getAttributes()
    {
        $attributes = isset($this->options['attrs']) ? $this->options['attrs'] : array();

        if (!isset($attributes['class'])) {
            $attributes['class'] = array();
        }
        $classes = array($this->getFieldName(), 'pc-condensed');
        $attributes['class'] = array_merge($attributes['class'], $classes);

        return $attributes;
    }
}