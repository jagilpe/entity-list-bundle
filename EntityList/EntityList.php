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
     * @var array
     */
    protected $columns = array();

    protected $entities;

    public function __construct(array $entities, $options = array())
    {
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
        return new SimpleHeader($this->columns);
    }

    /**
     * Returns the body
     *
     * @return BodyInterface
     */
    public function getBody()
    {
        return new SimpleBody($this->entities, $this->columns, $this->options);
    }

    /**
     * Returns the fields used in the different cells of the list
     *
     * @return string[]
     */
    public function getFields()
    {
        $fields = array();
        foreach ($this->columns as $column) {
            $fields = array_merge($fields, $column->getFields());
        }

        return $fields;
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