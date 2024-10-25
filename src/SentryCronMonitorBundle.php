<?php

declare(strict_types=1);

namespace bmL\SentryCronMonitorBundle;

use bmL\SentryCronMonitorBundle\DependencyInjection\Compiler\AddCronMonitorOptionsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SentryCronMonitorBundle extends Bundle
{
    public const SDK_IDENTIFIER = 'sentry.php.symfony';

    public const SDK_VERSION = '4.0.1';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AddCronMonitorOptionsCompilerPass());
    }
}
