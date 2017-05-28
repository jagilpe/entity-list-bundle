<?php

namespace Jagilpe\EntityListBundle\EntityList;

use Jagilpe\EntityListBundle\Render\RenderableInterface;
use Jagilpe\EntityListBundle\Exception\EntityListException;
use Jagilpe\EntityListBundle\EntityList\Column\ColumnInterface;
use Jagilpe\EntityListBundle\Render\RenderableBaseTrait;
use Jagilpe\EntityListBundle\EntityList\Header\SimpleHeader;
use Jagilpe\EntityListBundle\EntityList\Body\SimpleBody;
use Jagilpe\EntityListBundle\EntityList\Header\HeaderInterface;
use Jagilpe\EntityListBundle\EntityList\Body\BodyInterface;

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
     * @see \Jagilpe\EntityListBundle\Render\RenderableInterface::getWidget()
     */
    public function getBlockName()
    {
        return 'jgp_entity_list';
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\Render\RenderableInterface::getChildren()
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
     * @see \Jagilpe\EntityListBundle\Render\RenderableInterface::getAttributes()
     */
    public function getAttributes()
    {
        $attributes = isset($this->options['attrs']) ? $this->options['attrs'] : array();

        $attributes['id'] = $this->getUniqueId();

        if (!isset($attributes['class'])) {
            $attributes['class'] = array();
        }
        $classes = array('table-responsive');
        $attributes['class'] = array_merge($attributes['class'], $classes);
        $attributes['data-terms'] = implode(',', $this->getFields());
        $attributes['data-items-per-page'] = $this->options['pager-items-per-page'];

        return $attributes;
    }

    /**
     * Returns a unique id for the list wrapper element. This id is required by the
     * pagination plugin of the List.js library
     *
     * @return string
     */
    protected function getUniqueId()
    {
        return md5(uniqid(rand(), true));
    }
}