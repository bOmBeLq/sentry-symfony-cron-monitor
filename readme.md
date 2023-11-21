## Sentry Cron Monitoring Symfony Bundle
### About

This extension allows to configure sentry cron monitoring with pretty much any scheduled jobs provider.

### Setup

1. Make sure you setup base sentry-symfony extension https://github.com/getsentry/sentry-symfony
2. `composer require bml/sentry-symfony-cron-monitor`
3. Enable `SentryCronMonitorBundle` in your `bundles.php` or `Kernel` (it may be automatically added by SF flex)

### Usage

Add cron monitoring slug and schedule to your command parameters. ref.
>      --cron-monitor-slug=CRON-MONITOR-SLUG                  if command should be monitored then pass cron monitor slug
>      --cron-monitor-schedule=CRON-MONITOR-SCHEDULE          if command should be monitored then pass cron monitor schedule
>      --cron-monitor-max-time=CRON-MONITOR-MAX-TIME          if command should be monitored then pass cron monitor max execution time
>      --cron-monitor-check-margin=CRON-MONITOR-CHECK-MARGIN  if command should be monitored then pass cron monitor check margin
example usage in crontab

```
0 0 * * *   user    /app/bin/console app:statistics:update --cron-monitor-slug=statistics_update_midnight --cron-monitor-schedule "0 0 * * *"
```

Optionally you can also set max run time and check margin (see https://docs.sentry.io/platforms/php/crons/for ref.)

```
0 0 * * *   user    /app/bin/console app:statistics:update --cron-monitor-slug=statistics_update_midnight --cron-monitor-schedule "0 0 * * *" --cron-monitor-max-time=5 --cron-monitor-check-margin=2
```

#### Crontab helper command
The `bml:sentry-symfony-cron-monitor:add-schedule-argument-to-crontab` command will take crontab file path and will add the 
`--cron-monitor-schedule=THE_SCHEDULE` to lines containing `--cron-monitor-slug`.   
This way the crontab file can be more DRY because you don't need to keep the --cron-monitor-schedule=THE_SCHEDULE.
Instead it's auto added during deploy/build. Just use this command in your ci/cd.

## Development

## Setup

Run `.docker/bin/setup-dev.sh {PHP_VERSION}`  
eg. `.docker/bin/setup-dev.sh 8.1`  
Default php version is 7.2 `.docker/bin/setup-dev.sh`

### Tests
    
Run `.docker/bin/run-tests.sh`  
For xdebug experience `.docker/bin/run-tests-xdebug.sh`  
To run tests against specific php version use

```
.docker/bin/setup-dev.sh 7.4
.docker/bin/run-tests.sh
```

### php-cs-fixer

Run `.docker/bin/run-php-cs-fixer.sh`  
Beware this command internally runs `.docker/bin/setup-dev.sh 8.1` (changes container php-version)

