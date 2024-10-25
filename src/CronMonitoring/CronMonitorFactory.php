<?php

declare(strict_types=1);

namespace bmL\SentryCronMonitorBundle\CronMonitoring;

use Sentry\MonitorConfig;
use Sentry\MonitorSchedule;
use Sentry\State\HubInterface;

class CronMonitorFactory
{
    public function __construct(private HubInterface $hub)
    {
    }

    public function create(string $slug, string $schedule, ?int $checkMarginMinutes = null, ?int $maxRuntimeMinutes = null): CronMonitor
    {
        $monitorSchedule = MonitorSchedule::crontab($schedule);
        $monitorConfig = new MonitorConfig(
            $monitorSchedule,
            $checkMarginMinutes,
            $maxRuntimeMinutes,
            date_default_timezone_get()
        );

        return new CronMonitor($this->hub, $monitorConfig, $slug);
    }
}
