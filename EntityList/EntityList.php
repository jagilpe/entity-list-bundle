<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\Render\RenderableInterface;
use Module7\ComponentsBundle\Exception\EntityListException;
use Module7\ComponentsBundle\EntityList\Column\ColumnInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use Module7\ComponentsBundle\EntityList\Header\SimpleHeader;
use Module7\ComponentsBundle\EntityList\Row\SimpleRow;
use Module7\ComponentsBundle\EntityList\Body\SimpleBody;
use Module7\ComponentsBundle\EntityList\Header\HeaderInterface;
use Module7\ComponentsBundle\EntityList\Body\BodyInterface;

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

    protected $entities;

    public function __construct($entityClass, array $entities, $options = array())
    {
        if (!class_exists($entityClass)) {
            throw new EntityListException("Class $entityClass does not exists.");
        }

        $this->entityClass = $entityClass;
        $this->options = $options;
        $this->entities = $entities;
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
        $children[] = $this->getHeader();
        $children[] = $this->getBody();

        return $children;
    }

    /**
     * Returns the header
     *
     * @return HeaderInterface
     */
    public function getHeader()
    {
        return new SimpleHeader($this->entityClass, $this->columns);
    }

    /**
     * Returns the body
     *
     * @return BodyInterface
     */
    public function getBody()
    {
        return new SimpleBody($this->entities, $this->columns);
    }

    /**
     * Returns the fields used in the different cells of the list
     *
     * @return string[]
     */
    public function getFields()
    {
//         $fields = array();
//         foreach ($this->columns as $column) {

//         }
        return array('name');
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\Render\RenderableInterface::getAttributes()
     */
    public function getAttributes()
    {
        $attributes = isset($this->options['attrs']) ? $this->options['attrs'] : array();

        if (!isset($attributes['class'])) {
            $attributes['class'] = array();
        }
        $classes = array('table-responsive', 'm7-searchable-table');
        $attributes['class'] = array_merge($attributes['class'], $classes);

        $attributes['data-terms'] = implode(',', $this->getFields());

        return $attributes;
    }
}