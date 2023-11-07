#!/bin/bash
set -e
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
if [ "$1" == "" ]; then
    PHP_VERSION=7.2
else
    PHP_VERSION=$1
fi
docker build -t sentry-symfony-ctron-monitor:$PHP_VERSION -t sentry-symfony-ctron-monitor --build-arg PHP_VERSION=$PHP_VERSION $SCRIPT_DIR/../
rm -rf $SCRIPT_DIR/../../vendor
$SCRIPT_DIR/run-dev.sh composer install
rm composer.lock
