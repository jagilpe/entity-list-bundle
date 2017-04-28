<?php

namespace Jagilpe\EntityListBundle\EntityList\Row;

use Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface;
use Jagilpe\EntityListBundle\Render\RenderableBaseTrait;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class SimpleRow implements RowInterface
{
    use RenderableBaseTrait;

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
     * @see \Jagilpe\EntityListBundle\Render\RenderableInterface::getChildren()
     */
    public function getChildren()
    {
        $entity = $this->entity;
        $children = array_map(function(ColumnInterface $column) use ($entity) {
            return $column->getCellElement($entity);
        }, $this->columns);

        return $children;
    }


    /**
     *
     * {@inheritdoc}
     *
     * @see \Jagilpe\EntityListBundle\Render\RenderableInterface::getBlockName()
     */
    public function getBlockName()
    {
        return 'jgp_simple_row';
    }

}