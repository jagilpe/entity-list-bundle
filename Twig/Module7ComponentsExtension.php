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

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
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
        $functions = array();
        $functions[] = new EntityElementRenderer($this->twig, 'm7_list_render');
        $functions[] = new EntityElementRenderer($this->twig, 'm7_element_render');

        return $functions;
    }
}