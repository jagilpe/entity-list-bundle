<?php
namespace Module7\ComponentsBundle\EntityList;

use Symfony\Component\Debug\Exception\UndefinedMethodException;
use Module7\ComponentsBundle\Exception\EntityListException;

/**
 * Entity wrapper class used as a proxy to access the data required
 * by the different EntityLists
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class EntityListItemFieldIterator implements \Iterator, \Countable
{
    protected $entity;

    /**
     * @var \ArrayIterator
     */
    protected $fields;

    private $reflectionClass;

    public function __construct($entity, array $fields)
    {
        $this->entity = $entity;
        $this->reflectionClass = new \ReflectionClass($entity);

        $this->fields = new \ArrayIterator($fields);
    }

    /**
     * @return object
     */
    public function getEntity() {
        return $this->entity;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $field = $this->fields->current();

        return $this->getValue($field);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->fields->current();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->fields->next();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->fields->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->fields->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->fields->count();
    }

    /**
     * Returns the value for a determined field name
     *
     * @param string $field
     *
     * @return mixed
     *
     * @throws UndefinedMethodException
     */
    protected function getValue($field)
    {
        $options = $field['options'];

        // First check if we have a callback for this field
        if (isset($field['callback'])) {
            $object = $field['callback'][0];
            $method = $field['callback'][1];

            $value = $object->{$method}($this->entity);
        }
        elseif (isset($field['field_name'])) {
            $fieldName = $field['field_name'];
            $found = false;

            // Check if this is a field of a related entity
            $fieldExplode = explode('::', $fieldName);
            if (count($fieldExplode) > 1) {
                $value = $this->getRelatedEntityValue($field, $fieldExplode);
            }
            else {
                // The field is an own property of the entity
                $fieldGetter = 'get'.ucfirst($fieldName);
                if ($this->reflectionClass->hasMethod($fieldGetter)) {
                    $value = $this->entity->{$fieldGetter}();
                }
            }
        }

        return new EntityListCell($value, $options);
    }

    protected function getRelatedEntityValue($field, $fieldExplode)
    {
        $value = null;
        $fieldName = $field['field_name'];
        $reflectionClass = $this->reflectionClass;
        $entity = $this->entity;

        // The value is a field of a subentity
        foreach ($fieldExplode as $subFieldName) {
            $getter = 'get'.ucfirst($subFieldName);

            if ($reflectionClass->hasMethod($getter)) {
                $value = $entity->{$getter}();

                if ($value) {
                    if (is_object($value)) {
                        // If there are more subfields to treat this is the next entity
                        $entity = $value;
                        $reflectionClass = new \ReflectionClass($entity);
                    }
                }
                else {
                    // We have no value for this field
                    break;
                }
            }
            else {
                throw new EntityListException('Error validating the field list');
            }
        }

        return $value;
    }
}