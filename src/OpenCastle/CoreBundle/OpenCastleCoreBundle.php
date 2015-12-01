<?php

namespace OpenCastle\CoreBundle;

use OpenCastle\CoreBundle\DependencyInjection\Compiler\GameEventCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OpenCastleCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new GameEventCompilerPass());
    }
}
