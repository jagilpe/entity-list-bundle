<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\Render\RenderableInterface;
use Module7\ComponentsBundle\Exception\EntityListException;
use Module7\ComponentsBundle\EntityList\Column\ColumnInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use Module7\ComponentsBundle\EntityList\Header\SimpleHeader;
use Module7\ComponentsBundle\EntityList\Row\SimpleRow;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class EntityList implements RenderableInterface
{
    use RenderableBaseTrait;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var array
     */
    protected $columns = array();

    protected $elements;

    public function __construct($entityClass, array $elements, $options = array())
    {
        if (!class_exists($entityClass)) {
            throw new EntityListException("Class $entityClass does not exists.");
        }

        $this->entityClass = $entityClass;
        $this->options = $options;
    }

    /**
     * Adds a column definition to the entity list
     *
     * @param ColumnInterface $column
     * @throws EntityListException
     */
    public function addColumn(ColumnInterface $column)
    {
        // First we have to check if the column is compatible with the entity class
        if (!$column->isCompatibleWithEntity($this->entityClass)) {
            throw new EntityListException('Column definition not compatible with entity class '.$this->entityClass);
        }

        $this->columns[] = $column;
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getWidget()
     */
    public function getBlockName()
    {
        return 'm7_entity_list';
    }

    /**
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getChildren()
     */
    public function getChildren()
    {
        $children = array();
        $children[] = new SimpleHeader($this->entityClass, $this->columns);

        // Add the rows
        foreach ($this->elements as $entity) {
            $children[] = new SimpleRow($entity, $this->columns);
        }

        return $children;
    }

    /**
     * Returns the header
     */
    public function getHeader()
    {

    }

    /**
     * Returns the fields used in the different cells of the list
     *
     * @return string[]
     */
    public function getFields()
    {
        return array('name', 'address');
    }
}