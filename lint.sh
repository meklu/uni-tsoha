#!/bin/sh
find . -type f -name '*\.php' -print0 | xargs -0 -I '{}' php -l '{}'
