<?php

namespace Module7\ComponentsBundle\Render;

/**
 * Defines a trait to reuse the most commons implementations of the RenderableInterface
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
trait RenderableBaseTrait
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getLabel()
     */
    public function getLabel()
    {
        $label = false;
        if (isset($this->options['label_callback'])
            && is_callable($this->options['label_callback'])) {
            $label = call_user_func($this->options['label_callback']);
        }

        if (!$label) {
            $label = isset($this->options['label']) ? $this->options['label'] : null;
        }

        return $label;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getOptions()
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getChildren()
     */
    public function getChildren()
    {
        return array();
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getAttributes()
     */
    public function getAttributes()
    {
        return isset($this->options['attrs']) ? $this->options['attrs'] : array();
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getVars()
     */
    public function getVars()
    {

    }
}