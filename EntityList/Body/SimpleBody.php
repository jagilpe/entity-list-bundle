<?php

namespace Module7\ComponentsBundle\EntityList\Body;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use Module7\ComponentsBundle\EntityList\Row\SimpleRow;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class SimpleBody implements BodyInterface
{
    use RenderableBaseTrait;

    /**
     *
     * @var array
     */
    protected $entities;

    /**
     *
     * @var array
     */
    protected $columns;

    public function __construct(array $entities, array $columns)
    {
        $this->entities = $entities;
        $this->columns = $columns;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getBlockName()
     */
    public function getBlockName()
    {
        return 'm7_simple_body';
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getChildren()
     */
    public function getChildren()
    {
        $children = array();

        // Add the rows
        foreach ($this->entities as $entity) {
            $children[] = new SimpleRow($entity, $this->columns);
        }

        return $children;
    }
}