<?php

namespace Module7\ComponentsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Module7\ComponentsBundle\DependencyInjection\Compiler\EntityListTypePass;

/**
 * This Bundle builds a reusable components
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class Module7ComponentsBundle extends Bundle
{
    /**
     *
     * {@inheritDoc}
     * @see \Symfony\Component\HttpKernel\Bundle\Bundle::build()
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new EntityListTypePass());
    }
}