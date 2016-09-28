<?php

namespace Module7\ComponentsBundle\Twig;

use Module7\ComponentsBundle\Twig\Functions\ListRenderer;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class Module7ComponentsExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
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
        $functions[] = new ListRenderer();

        return $functions;
    }
}