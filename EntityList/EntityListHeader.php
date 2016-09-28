<?php
namespace Module7\ComponentsBundle\EntityList;

/**
 * Helper class to build and render different type of Entities Lists
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class EntityListHeader
{
    protected $name;

    protected $options;

    public function __construct($name, $options = array())
    {
        $this->name = $name;
        $this->options = $options;
    }

    public function getName()
    {
        $prefix = isset($this->options['label_prefix']) ? $this->options['label_prefix'].'.' : '';
        return $prefix.$this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    public function getAttributes()
    {
        return isset($this->options['attributes']) ? $this->options['attributes'] : array();
    }
}