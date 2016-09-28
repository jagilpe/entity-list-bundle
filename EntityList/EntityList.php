<?php
namespace Module7\ComponentsBundle\EntityList;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Default implementation of the Module7\ComponentsBundle\EntityListInterface for doctrine collections
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class EntityList implements EntityListInterface
{
    /**
     * @var Doctrine\Common\Collections\Collection
     */
    protected $itemsCollection;

    /**
     * @var array
     */
    protected $fields = array();

    /**
     * Default fields options
     */
    protected $defaultOptions = array();

    /**
     * @var \ArrayIterator
     */
    protected $headers;

    /**
     * Default constructor
     *
     * @param array $entities
     * @param string/mixed $fields
     * @param array $options
     */
    public function __construct(array $entities = array(), $fields, $options = array())
    {
        $this->itemsCollection = new ArrayCollection();

        // Add the default options
        $options += $this->defaultOptions;
        if (isset($fields['rows'])) {
            foreach ($fields['rows'] as $fieldRow) {
                $this->fields[] = $this->normalizeFields($fieldRow, $options);
            }
        }
        else {
            $this->fields[] = $this->normalizeFields($fields, $options);
        }

        $this->setHeaders($this->fields[0]);

        foreach ($entities as $entity) {
            $this->addEntity($entity, $this->fields, $options);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\EntityListInterface::getHeaders()
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     *
     * {@inheritDoc}
     * @see IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
        return $this->itemsCollection->getIterator();
    }

    /**
     *
     * {@inheritDoc}
     * @see Countable::count()
     */
    public function count()
    {
        return $this->itemsCollection->count();
    }

    /**
     *
     * {@inheritDoc}
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        return $this->itemsCollection->offsetExists($offset);
    }

    /**
     *
     * {@inheritDoc}
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        return $this->itemsCollection->offsetGet($offset);
    }

    /**
     *
     * {@inheritDoc}
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        return $this->itemsCollection->offsetSet($offset, $value);
    }

    /**
     *
     * {@inheritDoc}
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        return $this->itemsCollection->offsetUnset($offset);
    }

    /**
     * Adds a new EntityListItem to the collection
     *
     * @param unknown $entity
     * @param unknown $fields
     * @param unknown $options
     */
    protected function addEntity($entity, $fields, $options)
    {
        $entityListItem = new EntityListItem($entity, $fields, $options);
        $this->itemsCollection->add($entityListItem);
    }

    /**
     * Adds the default common options to each of the fields
     *
     * @param array $fields
     * @param array $options
     *
     * @return boolean
     */
    protected function normalizeFields(array $fields, $options = array())
    {
        $normalizedFields = array();
        foreach ($fields as $field) {
            if (is_array($field)) {
                $field['options'] = isset($field['options']) ? $field['options'] : array();
                $field['options'] = array_merge_recursive($field['options'],$options);
            }
            else {
                $field = array(
                    'field_name' => $field,
                    'options' => $options,
                );
            }

            $normalizedFields[] = $field;
        }

        return $normalizedFields;
    }

    protected function setHeaders($fields)
    {
        $headers = array();

        foreach ($fields as $field) {
            $label = isset($field['label']) ? $field['label'] : $field['field_name'];
            $headers[] = new EntityListHeader($label, $field['options']);
        }

        $this->headers = new \ArrayIterator($headers);
    }
}