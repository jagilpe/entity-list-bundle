<?php

namespace Module7\ComponentsBundle\Twig;

use Module7\ComponentsBundle\Twig\Functions\EntityElementRenderer;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class Module7ComponentsExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     *
     * @var \Twig_Environment
     */
    private $twig;

    private $listsTheme;

    public function __construct(\Twig_Environment $twig, $listsTheme)
    {
        $this->twig = $twig;
        $this->listsTheme = $listsTheme;
    }

    /**
     * {@inheritDoc}
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'module7_components_bundle_extension';
    }

    /**
     * {@inheritDoc}
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
        $options = array(
            'lists_theme' => $this->listsTheme,
        );

        $functions = array();
        $functions[] = new EntityElementRenderer($this->twig, 'm7_list_render', $options);
        $functions[] = new EntityElementRenderer($this->twig, 'm7_element_render', $options);
        $functions[] = new \Twig_SimpleFunction(
            'm7_attributes',
            array($this, 'getAttributesString'),
            array(
                'is_safe' => array('html'),
            )
        );

        return $functions;
    }

    /**
     * Returns an string for the given attributes ready to be places in an html element
     *
     * @param array $attributes
     *
     * @return string
     */
    public function getAttributesString(array $attributes = array())
    {
        $attributesString = '';

        foreach ($attributes as $name => $values) {
            $value = is_array($values) ? implode(' ', $values) : $values;
            $attributesString .= ' '.$name.'="'.$value.'"';
        }

        return $attributesString;
    }
}