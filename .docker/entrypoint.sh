#!/bin/bash

if [ "$1" = "install" ]; then
  composer install --prefer-dist
  exit $?
fi

exec "$@"
 