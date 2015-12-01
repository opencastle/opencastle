<?php

namespace OpenCastle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class GameEventCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('opencastle_core.game_event_handler')) {
            return;
        }

        $definition = $container->findDefinition(
            'opencastle_core.game_event_handler'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'opencastle.game_event'
        );

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addEvent',
                array(new Reference($id))
            );
        }
    }
}
