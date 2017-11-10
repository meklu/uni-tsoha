#!/bin/sh
cd "$(dirname "$(readlink -f "$0")")"

find . -type d -not -path './\.git*' -print0 | xargs -0 chmod go+rx
find . -type f -not -path './\.git*' -print0 | xargs -0 chmod go+r
