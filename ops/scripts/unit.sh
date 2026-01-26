#!/bin/sh

test() {
  PHP_CMD="php-$1"
  # Check if php-{version} exists, otherwise use php
  if ! command -v $PHP_CMD > /dev/null 2>&1; then
    PHP_CMD="php"
  fi
  $PHP_CMD bin/phpspec run
}

for version in 5.5 5.6 7.0 7.1; do
  echo "Testing PHP $version"
  test $version
done