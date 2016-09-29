<?php

namespace Module7\ComponentsBundle\EntityList\Row;

use Module7\ComponentsBundle\EntityList\Column\ColumnInterface;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class SimpleRow implements RowInterface
{
    /**
     * @var mixed
     */
    protected $entity;

    /**
     * @var array<ColumnInterface>
     */
    protected $columns;

    public function __construct($entity, array $columns = array())
    {
        $this->entity = $entity;
        $this->columns = $columns;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getChildren()
     */
    public function getChildren()
    {
        return array();
        $children = array_map(function(ColumnInterface $column) use ($entity) {
            return $column->getCellContent($entity);
        }, $this->columns);

        return $children;
    }


    /**
     *
     * {@inheritdoc}
     *
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getBlockName()
     */
    public function getBlockName()
    {
        return 'm7_simple_row';
    }

}