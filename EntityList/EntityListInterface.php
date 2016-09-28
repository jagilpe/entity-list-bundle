<?php

namespace Module7\ComponentsBundle\EntityList;

/**
 * Defines the interface to work with an entity list
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
interface EntityListInterface extends \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * Returns the headers of the list
     *
     * @return array<EntityListHeaderInterface>
     */
    public function getHeaders();
}