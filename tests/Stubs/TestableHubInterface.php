<?php

declare(strict_types=1);

namespace bmL\SentryCronMonitorBundle\Tests\Stubs;

use Sentry\CheckInStatus;
use Sentry\MonitorConfig;
use Sentry\State\HubInterface;

interface TestableHubInterface extends HubInterface
{
    /**
     * @param int|float|null $duration
     */
    public function captureCheckIn(string $slug, CheckInStatus $status, $duration = null, ?MonitorConfig $monitorConfig = null, ?string $checkInId = null): ?string;
}
