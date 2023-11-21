<?php

declare(strict_types=1);

namespace bmL\SentryCronMonitorBundle\Tests\End2End;

use bmL\SentryCronMonitorBundle\CronMonitoring\CronMonitor;
use bmL\SentryCronMonitorBundle\CronMonitoring\CronMonitorFactory;
use bmL\SentryCronMonitorBundle\Tests\End2End\App\Kernel;
use bmL\SentryCronMonitorBundle\Tools\CrontabFileHelper;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\NullOutput;

class AddScheduleArgumentToCrontabCommandTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    public function testCronMonitorSuccess()
    {
        $file = __DIR__ . '/../Tools/_resources/crontab';
        $expectedFile = __DIR__ . '/../Tools/_resources/crontab.expected';

        $tmpFile = sys_get_temp_dir() . '/' . uniqid();
        copy($file, $tmpFile);

        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $kernel->boot();

        $arguments = ['bin/console', 'bml:sentry-symfony-cron-monitor:add-schedule-argument-to-crontab', $tmpFile];

        $input = new ArgvInput($arguments);

        $exitCode = $application->run($input, new NullOutput());

        $this->assertEquals(Command::SUCCESS, $exitCode);
        $this->assertEquals(file_get_contents($expectedFile), file_get_contents($tmpFile));
        unlink($tmpFile);
    }

}
