<?php

namespace Module7\ComponentsBundle\Render;

/**
 * Defines the interface for the renderer
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
interface RendererInterface
{
    /**
     * Renders a renderable element
     *
     * @param RenderableInterface $renderable
     *
     * @return string
     */
    public function render(RenderableInterface $renderable);
}