#!/bin/sh
cd "$(dirname "$(readlink -f "$0")")"

./perms.sh

rsync -pvihurtz \
	--progress \
	--exclude ".git" \
	--links --copy-unsafe-links --delete \
	./ melker@users2017.cs.helsinki.fi:~/htdocs/"$(basename "$PWD")"/
