<?php

namespace Jagilpe\EntityListBundle\Twig\Functions;

use Jagilpe\EntityListBundle\Render\RendererInterface;
use Jagilpe\EntityListBundle\Render\RenderableInterface;
use Jagilpe\EntityListBundle\EntityList\EntityList;

/**
 * Implementation of the EntityList Renderer Interface for Twig
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
class EntityElementRenderer extends \Twig_SimpleFunction implements RendererInterface
{
    /**
     *
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig, $name = 'jgp_list_render', $options = array())
    {
        $this->twig = $twig;

        $options = array_merge(array(
            'is_safe' => array('html'),
        ), $options);
        parent::__construct($name, array($this, 'render'), $options);
    }

     /**
      * {@inheritDoc}
      * @see \Jagilpe\EntityListBundle\EntityList\Renderer\RendererInterface::render()
      */
    public function render(RenderableInterface $renderableElement)
    {
        $variables = array(
            'translation_domain' => isset($options['translation_domain']) ? $options['translation_domain'] : 'messages',
        );

        $template = $this->twig->loadTemplate($this->options['lists_theme']);
        $blockName = $renderableElement->getBlockName();

        return $template->renderBlock($blockName, array('element' => $renderableElement));
    }

}