<?php

declare(strict_types=1);

namespace bmL\SentryCronMonitorBundle\Tests\CronMonitoring;

use PHPUnit\Framework\TestCase;
use bmL\SentryCronMonitorBundle\CronMonitoring\CronMonitor;
use bmL\SentryCronMonitorBundle\CronMonitoring\CronMonitorFactory;
use Sentry\State\HubInterface;

final class CronMonitorFactoryTest extends TestCase
{
    /**
     * @dataProvider createDataProvider
     */
    public function testCreate(string $slug, string $schedule, ?int $checkMarginMinutes, ?int $maxRuntimeMinutes)
    {
        $hub = $this->createMock(HubInterface::class);

        $cronMonitorFactory = new CronMonitorFactory($hub);
        $cronMonitor = $cronMonitorFactory->create($slug, $schedule, $checkMarginMinutes, $maxRuntimeMinutes);

        $this->assertInstanceOf(CronMonitor::class, $cronMonitor);
    }

    public function createDataProvider(): array
    {
        return [
            ['slug', '* * * * *', 1, 1],
            ['slug2', '* * * * *', null, 2],
            ['example_slug', '2 * * * *', 3, null],
            ['example_slug2', '2/5 * * * *', null, null],
        ];
    }
}
