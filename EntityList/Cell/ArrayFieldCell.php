<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use AppBundle\Service\SettingsService;
use Module7\ComponentsBundle\Render\RenderableInterface;
use Module7\ComponentsBundle\Render\SimpleRenderableElement;

/**
 * Simple implementation of the CellInterface that simply returns the content of the field
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class ArrayFieldCell extends SingleFieldCell
{
    /**
     * Returns the value of the cell
     *
     * @param $entity
     *
     * @return string
     */
    protected function getValue($entity)
    {
        $values = $this->getFieldValue($entity);

        if ($this->formatter) {
            foreach ($values as $key => $value) {
                $values[$key] = $this->formatter->formatValue($value);
            }
        }
        else {
            foreach ($values as $key => $value) {
                if ($value instanceof \DateTime) {
                    $formatter = new DateTimeCellFormatter($this->getDateTimeFormat());
                    $values[$key] = $formatter->formatValue($value);
                }
            }
        }

        return implode(', ', $values);
    }

    /**
     * Returns the value of a related entity
     *
     * @param array $fieldExplode
     * @param mixed $entity
     * @return NULL
     */
    protected function getRelatedEntityValue($fieldExplode, $entity, \ReflectionClass $reflectionClass)
    {
        $subFieldName = array_shift($fieldExplode);
        $getter = $this->getFieldGetter($reflectionClass, $subFieldName);
        $entities = $getter->invoke($entity);

        $outValues = array();
        foreach ($entities as $entity) {
            $reflectionClass = new \ReflectionClass($entity);
            // The value is a field of a subentity
            foreach ($fieldExplode as $subFieldName) {
                $getter = $this->getFieldGetter($reflectionClass, $subFieldName);
                $outValue = $getter->invoke($entity);

                if ($outValue) {
                    if (is_object($outValue)) {
                        // If there are more subfields to treat this is the next entity
                        $entity = $outValue;
                        $reflectionClass = new \ReflectionClass($entity);
                    }
                }
                else {
                    // We have no value for this field
                    break;
                }
            }
            $outValues[] = $outValue;
        }

        return $outValues;
    }
}