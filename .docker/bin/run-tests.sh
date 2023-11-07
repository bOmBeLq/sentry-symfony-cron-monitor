#!/bin/bash

SCRIPT_DIR=$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" &>/dev/null && pwd)

$SCRIPT_DIR/run-dev.sh vendor/bin/phpunit "$@"
