#!/bin/bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

$SCRIPT_DIR/run-dev.sh php -d xdebug.start_with_request=1 -d xdebug.mode=debug vendor/bin/phpunit "$@"
