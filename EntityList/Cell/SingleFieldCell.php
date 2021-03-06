<?php

namespace Jagilpe\EntityListBundle\EntityList\Cell;
use Jagilpe\EntityListBundle\Exception\EntityListException;
use ReflectionMethod;

/**
 * Simple implementation of the CellInterface that simply returns the content of the field
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class SingleFieldCell extends AbstractCell
{
    /**
     *
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Cell\CellInterface::getFields()
     */
    public function getFields()
    {
        return array($this->fieldName);
    }

    /**
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Cell\AbstractCell::getCellContent()
     */
    protected function getCellContent($entity)
    {
        $content = $this->getValue($entity);
        if ($content && isset($this->options['translate_content']) && $this->options['translate_content']) {
            $translator = isset($this->options['translator']) ? $this->options['translator'] : null;
            if ($translator) {
                $content = isset($this->options['translation_content_prefix'])
                    ? $this->options['translation_content_prefix'].$content
                    : $content;

                $translationOptions = isset($this->options['translation_options'])
                    ? $this->options['translation_options']
                    : array();

                $translationDomain = isset($this->options['translation_domain'])
                    ? $this->options['translation_domain']
                    : null;

                $content = $translator->trans($content, $translationOptions, $translationDomain);
            }
        }
        return $content;
    }

    /**
     * Returns the value of the cell
     *
     * @param $entity
     *
     * @return string
     */
    protected function getValue($entity)
    {
        $value = $this->getFieldValue($entity);

        if ($this->formatter) {
            return $this->formatter->formatValue($value);
        }
        else {
            if ($value instanceof \DateTime) {
                $formatter = new DateTimeCellFormatter($this->getDateTimeFormat());
                return $formatter->formatValue($value);
            }
            else {
                return $value;
            }
        }
    }

    protected function getDateTimeFormat()
    {
        return isset($this->options['datetime_format'])
            ? $this->options['datetime_format']
            : 'd.m.Y H:i';
    }

    /**
     * @param mixed $entity
     * @return mixed|NULL
     */
    protected function getFieldValue($entity)
    {
        $reflectionClass = new \ReflectionClass($entity);

        $fieldName = $this->fieldName;

        // Check if this is a field of a related entity
        $fieldExplode = explode('::', $fieldName);
        if (count($fieldExplode) > 1) {
            $value = $this->getRelatedEntityValue($fieldExplode, $entity, $reflectionClass);
        }
        else {
            $reflectionProperty = $reflectionClass->hasProperty($fieldName)
            ? $reflectionClass->getProperty($fieldName) : false;
            if ($reflectionProperty && $reflectionProperty->isPublic()) {
                return $reflectionProperty->getValue($entity);
            }

            $getter = $this->getFieldGetter($reflectionClass, $fieldName);
            $value = $getter->invoke($entity);
        }

        return $value;
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
        $value = null;

        // The value is a field of a subentity
        foreach ($fieldExplode as $subFieldName) {
            $getter = $this->getFieldGetter($reflectionClass, $subFieldName);

            $value = $getter->invoke($entity);
            if ($value) {
                if (is_object($value)) {
                    // If there are more subfields to treat this is the next entity
                    $entity = $value;
                    $reflectionClass = new \ReflectionObject($entity);
                }
            }
            else {
                // We have no value for this field
                break;
            }
        }

        return $value;
    }

    /**
     * Returns the Reflection Method of the getter of the field
     *
     * @param \ReflectionClass $reflectionClass
     * @param string $fieldName
     * @throws EntityListException
     * @return ReflectionMethod
     */
    protected function getFieldGetter(\ReflectionClass $reflectionClass, $fieldName)
    {
        foreach (array('get', 'is', 'has') as $prefix) {
            $getter = $prefix.ucfirst($fieldName);
            $reflectionMethod = $reflectionClass->getMethod($getter);

            if ($reflectionMethod && $reflectionMethod->isPublic()) {
                return $reflectionMethod;
            }
        }

        throw new EntityListException("The field $fieldName does not exist or is not accessible.");
    }

    /**
     *
     * {@inheritDoc}
     * @see \Jagilpe\EntityListBundle\EntityList\Cell\AbstractCell::getDefaultBlockName()
     */
    protected function getDefaultBlockName()
    {
        return 'jgp_simple_cell';
    }
}