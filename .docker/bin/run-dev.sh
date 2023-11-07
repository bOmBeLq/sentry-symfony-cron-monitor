#!/bin/bash
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
CMD='bash'
if [[ "$@" != "" ]]; then
  CMD=$@
fi
docker run --network host -e PHP_IDE_CONFIG=serverName=sentry-symfony-cron-monitor -it -v ${SCRIPT_DIR}/../..:/app -w /app -u `id -u` -e PHP_CS_FIXER_IGNORE_ENV=1 sentry-symfony-ctron-monitor $CMD
