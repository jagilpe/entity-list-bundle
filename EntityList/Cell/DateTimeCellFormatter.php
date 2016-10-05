<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Exception\EntityListException;

/**
 * A Cell formatter for datetimes
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class DateTimeCellFormatter implements CellFormatterInterface
{
    /**
     *
     * @var string
     */
    private $format;

    /**
     * The format to
     * @param string $format
     */
    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module7\ComponentsBundle\EntityList\Cell\CellFormatterInterface::formatValue()
     */
    public function formatValue($value)
    {
        /**
         * @var \DateTime $value
         */
        if (!($value instanceof \DateTime)) {
            throw new EntityListException('The value to format must be a DateTime, '.get_class($value).' given.');
        }

        return $value->format($this->format);
    }
}