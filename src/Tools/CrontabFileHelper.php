<?php

namespace bmL\SentryCronMonitorBundle\Tools;

class CrontabFileHelper
{
    public function addScheduleArgumentToCrontabFileContents(string $crontabFilePath): void
    {
        $lines = [];
        $file = fopen($crontabFilePath, 'r+');
        while ($line = fgets($file)) {
            if (str_contains($line, '--cron-monitor-slug')) {
                if (str_contains($line, '--cron-monitor-schedule')) {
                    continue; // already added
                }
                if (!preg_match('/^(([^\s]+\s+){5})/', $line, $matches)) {
                    throw new \InvalidArgumentException('Could not match schedule for line containing --cron-monitor-slug - ' . $line);
                }
                $schedule = $matches[1];
                $schedule = preg_replace('/[\s\t]+/', ' ', $schedule);
                $schedule = trim($schedule);

                $cmsOption = '--cron-monitor-schedule="' . $schedule . '"';

                $line = preg_replace('/(--cron-monitor-slug(=| )[^\s]+)/', "$1 $cmsOption", $line);
            }
            $lines[] = $line;
        }
        file_put_contents($crontabFilePath, implode('', $lines));
    }
}
