<?php

namespace Module7\ComponentsBundle\EntityList\Header;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use Module7\ComponentsBundle\EntityList\Column\ColumnInterface;
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
     *
     * @var ArrayCollection
     */
    protected $columns;

    public function __construct(array $columns = array())
    {
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
        $children = array_map(function(ColumnInterface $column) {
            return $column->getHeader();
        }, $this->columns);

        return $children;
    }
}