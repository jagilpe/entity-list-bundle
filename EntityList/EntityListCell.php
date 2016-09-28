<?php
namespace Module7\ComponentsBundle\EntityList;

/**
 * Helper class to build and render different type of Entities Lists
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class EntityListCell
{
    protected $value;

    protected $options;

    public function __construct($value, $options = array())
    {
        $this->value = $value;
        $this->options = $options;
    }

    /**
     * Returns the parsed value for the cell
     *
     * @return string
     */
    public function getValue()
    {
        if ($this->value instanceof \DateTime) {
            $value = $this->value->format($this->options['date_format']);
        }
        else {
            $value = $this->value;
        }
        return $value;
    }

    /**
     * Returns the options
     *
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function getAttributes()
    {
        return isset($this->options['attributes']) ? $this->options['attributes'] : array();
    }
}