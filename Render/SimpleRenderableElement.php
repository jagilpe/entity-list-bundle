<?php

namespace Module7\ComponentsBundle\Render;

use Prophecy\Exception\Doubler\MethodNotFoundException;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class SimpleRenderableElement extends AbstractRenderableElement
{
    /**
     * @var array
     */
    protected $content;

    public function __construct($content, array $options = array())
    {
        $this->options = $options;
        $this->content = $content;
    }

    /**
     * Intercepts getter calls and search for the element in content
     *
     */
    public function __call($name, $arguments)
    {
        if (isset($this->content[$name])) {
            return $this->content[$name];
        }
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getLabel()
     */
    public function getLabel()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getBlockName()
     */
    public function getBlockName()
    {
        $blockName = isset($this->options['block_name']) ? $this->options['block_name'] : 'm7_simple_element';
        return $blockName;
    }
}