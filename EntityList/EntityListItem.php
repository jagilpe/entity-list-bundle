<?php

namespace Module7\ComponentsBundle\EntityList;

/**
 * Entity wrapper class used as a proxy to access the data required
 * by the different EntityLists
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class EntityListItem implements \Iterator, \Countable
{
    /**
     */
    protected $entity;

    /**
     * @var \ArrayIterator
     */
    protected $rows;

    protected $options;

    public function __construct($entity, array $fields, $options = array())
    {
        $this->entity = $entity;

        $rows = array();
        foreach ($fields as $fieldsRow) {
            $rows[] = new EntityListItemFieldIterator($entity, $fieldsRow);
        }

        $this->rows = new \ArrayIterator($rows);
        $this->options = $options;
    }

    public function getDetailUrl()
    {
        $url = '';

        if (isset($this->options['detailUrlCallback'])) {
            $object = $this->options['detailUrlCallback'][0];
            $method = $this->options['detailUrlCallback'][1];

            return $object->{$method}($this->entity);
        }
    }

    /**
     * Returns the entity
     */
    public function getEntity() {
        return $this->entity;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->rows->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->rows->current();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->rows->next();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->rows->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->rows->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->rows->count();
    }
}