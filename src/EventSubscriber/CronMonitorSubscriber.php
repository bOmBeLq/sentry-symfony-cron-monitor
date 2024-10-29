<?php

declare(strict_types=1);

namespace bmL\SentryCronMonitorBundle\EventSubscriber;

use bmL\SentryCronMonitorBundle\CronMonitoring\CronMonitor;
use bmL\SentryCronMonitorBundle\CronMonitoring\CronMonitorFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CronMonitorSubscriber implements EventSubscriberInterface
{
    private ?CronMonitor $cronMonitor = null;

    public function __construct(private CronMonitorFactory $cronMonitorFactory)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::COMMAND => 'onConsoleCommandStart',
            ConsoleEvents::TERMINATE => 'onConsoleCommandTerminate',
        ];
    }

    public function onConsoleCommandStart(ConsoleCommandEvent $event): void
    {
        if (!$event->getInput()->hasOption('cron-monitor-slug')) {
            return; // Cron monitor not enabled in application
        }

        $slug = $event->getInput()->getOption('cron-monitor-slug');
        $schedule = $event->getInput()->getOption('cron-monitor-schedule');
        $maxTime = $event->getInput()->getOption('cron-monitor-max-time');
        $checkMargin = $event->getInput()->getOption('cron-monitor-check-margin');

        if ($slug && $schedule) {
            $this->cronMonitor = $this->cronMonitorFactory->create($slug, $schedule, $checkMargin ? (int) $checkMargin : null, $maxTime ? (int) $maxTime : null);
            $this->cronMonitor->start();
        }
    }

    public function onConsoleCommandTerminate(ConsoleTerminateEvent $event): void
    {
        if ($this->cronMonitor) {
            if (Command::SUCCESS === $event->getExitCode()) {
                $this->cronMonitor->finishSuccess();
            } else {
                $this->cronMonitor->finishError();
            }
        }
    }
}
