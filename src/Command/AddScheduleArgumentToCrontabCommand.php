<?php

namespace bmL\SentryCronMonitorBundle\Command;

use bmL\SentryCronMonitorBundle\Tools\CrontabFileHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddScheduleArgumentToCrontabCommand extends Command
{
    /**
     * @var CrontabFileHelper
     */
    private $crontabFileHelper;

    public function __construct(CrontabFileHelper $crontabFileHelper)
    {
        $this->crontabFileHelper = $crontabFileHelper;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('bml:sentry-symfony-cron-monitor:add-schedule-argument-to-crontab')
            ->setDescription('Adds the --cron-monitor-schedule basing on crontab entry schedule so you don\'t have to specify it twice')
            ->addArgument('crontab-file', InputArgument::REQUIRED, 'crontab file path');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('crontab-file');
        $this->crontabFileHelper->addScheduleArgumentToCrontabFileContents($file);
        return Command::SUCCESS;
    }


}
