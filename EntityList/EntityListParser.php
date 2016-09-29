<?php

namespace Module7\ComponentsBundle\EntityList;

use Module7\ComponentsBundle\Exception\EntityListException;

/**
 * Parser for the entity lists
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class EntityListParser
{
    public function render(EntityList $list)
    {
        throw new EntityListException();
    }
}