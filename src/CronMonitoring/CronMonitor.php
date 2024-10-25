<?php

declare(strict_types=1);

namespace bmL\SentryCronMonitorBundle\CronMonitoring;

use Sentry\CheckInStatus;
use Sentry\MonitorConfig;
use Sentry\State\HubInterface;

class CronMonitor
{
    private string $checkInId;

    public function __construct(private HubInterface $hub, private MonitorConfig $monitorConfig, private string $slug)
    {
    }

    public function start(): void
    {
        $this->checkInId = $this->hub->captureCheckIn(
            $this->slug,
            CheckInStatus::inProgress(),
            null,
            $this->monitorConfig
        );
    }

    public function finishSuccess(): ?string
    {
        return $this->hub->captureCheckIn(
            $this->slug,
            CheckInStatus::OK(),
            null,
            $this->monitorConfig,
            $this->checkInId
        );
    }

    public function finishError(): ?string
    {
        return $this->hub->captureCheckIn(
            $this->slug,
            CheckInStatus::error(),
            null,
            $this->monitorConfig,
            $this->checkInId
        );
    }
}
