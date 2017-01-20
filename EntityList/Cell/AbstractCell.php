<?php

namespace Module7\ComponentsBundle\EntityList\Cell;

use Module7\ComponentsBundle\Render\RenderableBaseTrait;
use AppBundle\Service\SettingsService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Module7\ComponentsBundle\Render\SimpleRenderableElement;

/**
 * Abstract class to be used as base to implement the CellInterface
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
abstract class AbstractCell implements CellInterface
{
    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var string
     */
    protected $formatter;

    /**
     * @var array
     */
    protected $options;

    public function __construct($fieldName, array $options = array())
    {
        $this->fieldName = $fieldName;

        if (isset($options['formatter'])) {
            if ($options['formatter'] instanceof CellFormatterInterface) {
                $this->formatter = $options['formatter'];
            }
        }

        $options['block_name'] = isset($options['block_name']) ?  $options['block_name'] : $this->getDefaultBlockName();

        $attributes = isset($options['attrs']) ? $options['attrs'] : array();

        if (!isset($attributes['class'])) {
            $attributes['class'] = array();
        }
        $classes = is_array($attributes['class']) ? $attributes['class'] : array($attributes['class']);
        $attributes['class'] = array_merge($classes, array($this->getFieldName(), 'pc-condensed'));

        $options['attrs'] = $attributes;

        $this->options = $options;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Module7\ComponentsBundle\EntityList\Cell\CellInterface::getCellElement()
     */
    public function getCellElement($entity)
    {
        $content = array(
            'fieldName' => $this->fieldName,
            'value' => $this->getCellContent($entity),
            'rawValue' => $this->getFieldValue($entity),
        );
        return new SimpleRenderableElement($content, $this->options);
    }

    /**
     * Returns the name of the field
     *
     * @return NULL|string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    private function getDateTimeFormat()
    {
        return isset($this->options['datetime_format'])
            ? $this->options['datetime_format']
            : SettingsService::DEFAULT_DATE_FORMAT;
    }

    /**
     * Returns the default block name
     *
     * @return string
     */
    abstract protected function getDefaultBlockName();

    /**
     * Returns the content to be rendered in the cell
     *
     * @param mixed $entity
     * @return string
     */
    abstract protected function getCellContent($entity);

    /**
     * Returns the value from the entity
     *
     * @param $entity
     * @return mixed
     */
    abstract protected function getFieldValue($entity);
}