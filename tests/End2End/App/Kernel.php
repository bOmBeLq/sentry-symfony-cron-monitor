<?php

declare(strict_types=1);

namespace bmL\SentryCronMonitorBundle\Tests\End2End\App;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;
use Symfony\Component\Messenger\MessageBusInterface;

class Kernel extends SymfonyKernel
{
    /**
     * @var string
     */
    private static $cacheDir = null;

    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        $bundles = [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \bmL\SentryCronMonitorBundle\SentryCronMonitorBundle(),
            new \Sentry\SentryBundle\SentryBundle(),
        ];

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config.yml');
    }

    protected function build(ContainerBuilder $container): void
    {
        $container->setParameter('routing_config_dir', __DIR__);

        parent::build($container);
    }

    public function getCacheDir(): string
    {
        if (null === self::$cacheDir) {
            self::$cacheDir = sys_get_temp_dir() . \DIRECTORY_SEPARATOR . uniqid('sentry-symfony-cron-monitor');
        }

        return self::$cacheDir;
    }
}
