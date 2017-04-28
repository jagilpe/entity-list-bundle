<?php

namespace Jagilpe\EntityListBundle\EntityList\Body;

use Jagilpe\EntityListBundle\Render\RenderableBaseTrait;
use Jagilpe\EntityListBundle\EntityList\Row\SimpleRow;

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

    public function __construct(array $entities, array $columns, array $options = array())
    {
        $this->entities = $entities;
        $this->columns = $columns;
        $this->options = $options;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Jagilpe\EntityListBundle\Render\RenderableInterface::getBlockName()
     */
    public function getBlockName()
    {
        return 'jgp_simple_body';
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\Render\RenderableInterface::getChildren()
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