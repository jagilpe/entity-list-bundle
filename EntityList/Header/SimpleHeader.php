<?php

namespace Module7\ComponentsBundle\EntityList\Header;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Defines a simple header for an entity list
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class SimpleHeader implements HeaderInterface
{
    use RenderableBaseTrait;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     *
     * @var ArrayCollection
     */
    protected $columns;

    public function __construct($entityClass, ArrayCollection $columns)
    {
        $this->entityClass = $entityClass;
        $this->columns = $columns;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getWidget()
     */
    public function getBlockName()
    {
        return 'm7_simple_header';
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getChildren()
     */
    public function getChildren()
    {
        $children = array();

        return $children;
    }
}