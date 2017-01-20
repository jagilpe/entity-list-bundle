<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use AppBundle\Service\SettingsService;
use Module7\ComponentsBundle\Render\RenderableInterface;
use Doctrine\Common\Util\ClassUtils;

/**
 * Simple implementation of the CellInterface that simply returns the content of the field
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class DateTimeCell extends SingleFieldCell
{
    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Cell\AbstractCell::getDefaultBlockName()
     */
    protected function getDefaultBlockName()
    {
        return 'm7_datetime_cell';
    }
}