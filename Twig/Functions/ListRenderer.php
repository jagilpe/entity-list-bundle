<?php

namespace Module7\ComponentsBundle\Twig\Functions;

/**
 * Twig function for rendering entity lists
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class ListRenderer extends \Twig_SimpleFunction
{
    public function __construct($name = 'm7_list_render', $options = array())
    {
        $options = array_merge(array(
            'is_safe' => array('html'),
        ), $options);
        parent::__construct($name, array($this, 'renderList'), $options);
    }

    /**
     * Renders a list of entities
     *
     * @return string
     */
    public function renderList($text)
    {
        return "<div>$text</div>";
    }
}