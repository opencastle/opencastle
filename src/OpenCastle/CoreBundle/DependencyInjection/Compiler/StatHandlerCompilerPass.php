<?php

namespace OpenCastle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class StatHandlerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('opencastle_core.stat_handler.chain')) {
            return;
        }

        $definition = $container->getDefinition(
            'opencastle_core.stat_handler.chain'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'opencastle.stat_handler'
        );

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['priority'])) {
                    $attributes['priority'] = 0;
                }

                $definition->addMethodCall(
                    'addHandler',
                    array(new Reference($id), $attributes['priority'])
                );
            }
        }
    }
}
