<?php

namespace Jagilpe\EntityListBundle\EntityList\Header;

use Jagilpe\EntityListBundle\Render\RenderableBaseTrait;
use Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface;
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
     * @see \Jagilpe\EntityListBundle\Render\RenderableInterface::getWidget()
     */
    public function getBlockName()
    {
        return 'jgp_simple_header';
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\Render\RenderableInterface::getChildren()
     */
    public function getChildren()
    {
        $children = array_map(function(ColumnInterface $column) {
            return $column->getHeader();
        }, $this->columns);

        return $children;
    }
}