<?php

namespace Jagilpe\EntityListBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Jagilpe\EntityListBundle\DependencyInjection\Compiler\EntityListTypePass;

/**
 * This Bundle builds a reusable components
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class JagilpeEntityListBundle extends Bundle
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