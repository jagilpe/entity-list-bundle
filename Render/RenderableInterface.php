<?php

namespace Module7\ComponentsBundle\Render;

/**
 * Defines the interface for the rendeable elements
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
interface RenderableInterface
{
    /**
     * Returns the name of the name of the block to use to render the element
     *
     * @string
     */
    public function getBlockName();

    /**
     * Returns the label to use when rendering the element
     *
     * @string
     */
    public function getLabel();

    /**
     * Returns the children of this element that should be also rendered
     *
     * @return array<RenderableInterface>
     */
    public function getChildren();

    /**
     * Returns the options for rendering the element
     *
     * @return array
     */
    public function getOptions();

    /**
     * Returns the attribute for the main container element
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Returns the additional variables
     *
     * @return array
     */
    public function getVars();
}